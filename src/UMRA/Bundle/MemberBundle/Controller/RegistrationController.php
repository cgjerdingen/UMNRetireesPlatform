<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UMRA\Bundle\MemberBundle\Entity\Household;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Entity\Residence;
use UMRA\Bundle\MemberBundle\Entity\Trans;
use UMRA\Bundle\MemberBundle\Form\RegistrationFormType;
use UMRA\Bundle\MemberBundle\Form\RegistrationType;
use UMRA\Bundle\MemberBundle\Form\RenewalType;
use UMRA\Bundle\MemberBundle\Services\PayPalApiService;

use PayPal\Api\Amount;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        if ($user == null) {
            // Use the full registration form if no one is logged in.
            $form = $this->createForm(new RegistrationFormType(), array(
                'household' => new Household(),
                'members' => array(new Person()),
                'residences' => array(new Residence())
            ));
        } else {
            // Otherwise, just use the small registration form
            $form = $this->createForm(new RegistrationType());
        }

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $transBuilder = $this->get('umra_member.handlers.membership_transaction_builder');

                if ($form instanceof RegistrationFormType) {
                    // Create household, members, etc. for the full form
                    $userManager = $this->container->get('fos_user.user_manager');
                    $userMailer = $this->container->get('fos_user.mailer');

                    $formData = $form->getData();
                    $household = $formData["household"];

                    // Persist household.
                    $em->persist($household);
                    $em->flush();

                    $memberEmails = array();

                    $personCreateHandler = $this->container->get('umra_member.handlers.person_create');

                    // Persist each user.
                    foreach ($formData['members'] as $member) {
                        $procMember = $personCreateHandler->process($member, true, $household);
                        $procEmailCanonical = $procMember->getEmailCanonical();

                        if (!empty($procEmailCanonical)) {
                            $memberEmails[] = $procEmailCanonical;
                        }
                    }

                    // Persist each residence
                    foreach ($formData['residences'] as $key => $res) {
                        $res->setHousehold($household);
                        $em->persist($res);
                    }

                    // Send out password reset email
                    for ($i = 0; $i < count($memberEmails); $i++) {
                        $user = $userManager->findUserByEmail($memberEmails[$i]);
                        $userMailer->sendResettingEmailMessage($user);
                    }

                    // The "member" is to be the first person specified
                    $member = $formData["members"][0];
                } else {
                    $member = $this->get('security.token_storage')->getToken()->getUser();
                }

                $transOptions = $transBuilder->buildOptions($form);

                $transactions = $transBuilder->build($member, $transOptions);

                // If it's a check, let's stop here.
                if ($transOptions["pmtMethod"] === "CHECK")
                {
                    return $this->render('UMRAMemberBundle:Payment:success.html.twig', array(
                        'title' => 'Thanks for registering!',
                        'content_block_key' => 'registration.complete',
                        'transactions' => $transactions
                    ));
                }

                return $this->processPaypal($transactions, $transOptions);
            }
        }

        return $this->render('UMRAMemberBundle:Registration:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function renewAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!$user instanceof Person) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RenewalType());

        $mostRecentMembershipFee = $em->getRepository('UMRAMemberBundle:Trans')
            ->findLatestVerifiedMemberFee($user);

        if ($mostRecentMembershipFee instanceof Trans) {
            $lastRenewalDate = $mostRecentMembershipFee->getReconciledDate();
            $today = new \DateTime("now");

            $diff = $lastRenewalDate->diff($today);
            $diffDays = $diff->format("a");

            $diffFromRenewalMonth = $lastRenewalDate->diff(new \DateTime("first day of July this year"));
            $diffDaysJuly = $diffFromRenewalMonth->format("a");

            // It's been more than a year
            $isMembershipSoonToExpire = $diffDaysJuly >= 335 && $diffDays < 365;
            $isRenewalOverdue = $diff->format("a") >= 365;
            $isRenewalMonth = $today->format("n") === "7";

            // Hide renewal if user is active and their renewal is not overdue or soon to expire
            if ($user->isActivenow() && !$isRenewalOverdue && !$isMembershipSoonToExpire) {
                $renewalEligible = false;
            } else {
                $renewalEligible = true;
            }
        } else {
            $renewalEligible = false;
            $lastRenewalDate = null;
        }

        if ($renewalEligible && $request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $transBuilder = $this->get('umra_member.handlers.membership_transaction_builder');

                $transOptions = $transBuilder->buildOptions($form, "MEMBERSHIP_RENEW");

                $transactions = $transBuilder->build($user, $transOptions);

                // If it's a check, let's stop here.
                if ($transOptions["pmtMethod"] === "CHECK")
                {
                    return $this->render('UMRAMemberBundle:Payment:success.html.twig', array(
                        'title' => 'Thanks for renewing!',
                        'content_block_key' => 'renewal.complete',
                        'transactions' => $transactions
                    ));
                }

                return $this->processPaypal($transactions, $transOptions);
            }
        }

        return $this->render('UMRAMemberBundle:Registration:renew.html.twig', array(
            'form' => $form->createView(),
            'renewalEligible' => $renewalEligible,
            'lastRenewalDate' => $lastRenewalDate
        ));
    }

    private function processPaypal(array $transactions, array $transOptions) {
        $logger = $this->get('logger');

        $config = array(
            'client_id'     => $this->container->getParameter('paypal_client_id'),
            'client_secret' => $this->container->getParameter('paypal_client_secret'),
            'environment'   => $this->container->getParameter('paypal_environment')
        );

        $apiContext = PayPalApiService::getApiContext($config);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Build out PayPal ItemList from transactions
        $items = PayPalApiService::getItemsFromTransactions(
            $transactions,
            $transOptions["couponCount"],
            $transOptions["luncheons"]["attendeeCount"]
        );
        $itemList = new ItemList();
        $itemList->setItems($items);

        $totalCost = PayPalApiService::getTotalFromItems($items);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($totalCost);

        $ppTransaction = new Transaction();
        $ppTransaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("UMRA Membership")
            ->setInvoiceNumber($transOptions["invoiceId"]);

        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl($this->generateUrl("UMRA_Trans_paypal_callback_success", array(), true))
            ->setCancelUrl($this->generateUrl("UMRA_Trans_paypal_callback_cancel", array(), true));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($ppTransaction));

        try {
            $payment->create($apiContext);
        } catch (\Exception $ex) {
            $json = $ex->getData();
            $logger->error($json);

            return $this->render('UMRAMemberBundle:Payment:failure.html.twig');
        }

        $approvalUrl = $payment->getApprovalLink();

        return $this->redirect($approvalUrl);
    }
}
