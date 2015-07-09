<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UMRA\Bundle\MemberBundle\Entity\Email;
use UMRA\Bundle\MemberBundle\Entity\Household;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Entity\Residence;
use UMRA\Bundle\MemberBundle\Entity\Trans;
use UMRA\Bundle\MemberBundle\Form\RegistrationFormType;
use UMRA\Bundle\MemberBundle\Form\RenewalType;
use UMRA\Bundle\MemberBundle\Services\PayPalApiContextService;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $logger = $this->get('logger');
        $em = $this->getDoctrine()->getManager();
        $household = new Household();

        $form = $this->createForm(new RegistrationFormType(), array(
            'household' => $household,
            'members' => array(new Person()),
            'residences' => array(new Residence())
        ));

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            // TODO: Validate membershipStatus & membershipType combinations

            if ($form->isValid()) {
                $userManager = $this->container->get('fos_user.user_manager');
                $tokenGenerator = $this->container->get('fos_user.util.token_generator');
                $userMailer = $this->container->get('fos_user.mailer');

                $formData = $form->getData();

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

                if ($formData['membershipStatus'] === "new") {
                    $membershipStatus = "MEMBERSHIP_NEW";
                } else {
                    $membershipStatus = "MEMBERSHIP_RENEW";
                }

                for ($i = 0; $i < count($memberEmails); $i++) {
                    $user = $userManager->findUserByEmail($memberEmails[$i]);
                    $userMailer->sendResettingEmailMessage($user);
                }

                // Determine payment method.
                if ($form->get('payCreditCard')->isClicked()) {
                    $pmtMethod = 'CREDIT_CARD';
                } else {
                    $pmtMethod = 'CHECK';

                    // TODO: Move this?
                    $transactions = $this->processMembershipTransactions(
                        $em, $member, $membershipStatus, $pmtMethod,
                        $formData['membershipType']
                    );

                    return $this->render('UMRAMemberBundle:Registration:register_thanks.html.twig', array(
                        'transactions' => $transactions
                    ));
                }

                $config = array(
                    'client_id'     => $this->container->getParameter('paypal_client_id'),
                    'client_secret' => $this->container->getParameter('paypal_client_secret'),
                    'environment'   => $this->container->getParameter('paypal_environment')
                );

                $apiContext = PayPalApiContextService::getApiContext($config);

                $membershipCost = $formData['membershipType'];

                $isLuncheonPreorder = $formData["luncheonPreorder"] !== "0";

                if ($formData["luncheonPreorder"] == "112") {
                    $luncheonPeopleCount = 1;
                } elseif ($formData["luncheonPreorder"] == "224") {
                    $luncheonPeopleCount = 2;
                } else {
                    $luncheonPeopleCount = 0;
                }

                $couponCount = (int) $formData["parkingCoupon"];

                $payer = new Payer();
                $payer->setPaymentMethod("paypal");

                $items = $this->buildPaypalItems($em, $membershipCost, $isLuncheonPreorder, $luncheonPeopleCount, $couponCount, "MEMBERSHIP_NEW");

                $itemList = new ItemList();
                $itemList->setItems($items);

                $totalCost = ((float) $membershipCost) + ((float) $formData["luncheonPreorder"]);

                $amount = new Amount();
                $amount->setCurrency("USD")
                       ->setTotal($totalCost);

                $transaction = new Transaction();
                $transaction->setAmount($amount)
                            ->setItemList($itemList)
                            ->setDescription("UMRA Membership")
                            ->setInvoiceNumber(uniqid());

                $baseUrl = $request->getBasePath();
                $redirectUrls = new RedirectUrls();
                $redirectUrls
                  ->setReturnUrl($this->generateUrl("UMRA_Trans_paypal_callback_success", array(), true))
                  ->setCancelUrl($this->generateUrl("UMRA_Trans_paypal_callback_cancel", array(), true));

                $payment = new Payment();
                $payment->setIntent("sale")
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions(array($transaction));

                try {
                    $payment->create($apiContext);
                } catch (\Exception $ex) {
                    $json = $ex->getData();
                    print_r(json_decode($json));
                    exit(1);
                }

                $approvalUrl = $payment->getApprovalLink();

                return $this->redirect($approvalUrl);
            }
        }

        return $this->render('UMRAMemberBundle:Registration:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function renewAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if (!$user instanceof Person) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RenewalType());

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            $formData = $form->getData();

            if ($form->isValid()) {
                // Determine payment method.
                if ($form->get('payCreditCard')->isClicked()) {
                    $pmtMethod = 'CREDIT_CARD';
                } else {
                    $pmtMethod = 'CHECK';
                }

                // TODO: Payment

                // TODO: After return from payment processor. Probably will get moved
                $transactions = $this->processMembershipTransactions($em, $user, "MEMBERSHIP_RENEW", $pmtMethod, $formData['membershipType']);

                return $this->render('UMRAMemberBundle:Registration:register_thanks.html.twig', array(
                    'transactions' => $transactions
                ));
            }
        }

        return $this->render('UMRAMemberBundle:Registration:renew.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function buildPaypalItems($em, $membershipCost, $isLuncheonPreorder, $luncheonPeopleCount, $couponCount, $tranType)
    {
        $items = array();
        $membershipFee = new Item();
        $membershipFee->setName('UMRA Membership - 1 Year')
                      ->setCurrency('USD')
                      ->setQuantity(1)
                      ->setSku($tranType)
                      ->setPrice((float) $membershipCost);
        $items[] = $membershipFee;

        if ($isLuncheonPreorder)
        {
            $luncheons = $em->getRepository('UMRAMemberBundle:Luncheon')
                            ->findLatestLuncheons(7, true, new \DateTime("now"));

            foreach ($luncheons as $luncheon)
            {
                $luncheonFee = new Item();
                $luncheonFee->setName((string) $luncheon)
                            ->setCurrency('USD')
                            ->setQuantity($luncheonPeopleCount)
                            ->setSku("LUNCHEON_FEE")
                            ->setPrice((float) $luncheon->getPrice());

                $items[] = $luncheonFee;
            }
        }

        if ($couponCount > 0) {
            $coupons = new Item();
            $coupons->setName('Free Parking Coupons')
                    ->setCurrency('USD')
                    ->setSku("OTHER")
                    ->setQuantity($couponCount)
                    ->setPrice(0);

            $items[] = $coupons;
        }

        return $items;
    }

    private function processMembershipTransactions($em, Person $member, $tranType, $pmtMethod, $membershipCost)
    {
        $transactions = array();

        // Create tranaction for membership fee.
        $membershipTrans = new Trans();
        $membershipTrans->setPerson($member)
                        ->setTrantype($tranType)
                        ->setTrandate(new \DateTime("now"))
                        ->setStatus("AWAITING_PROCESS")
                        ->setPmtmethod($pmtMethod)
                        ->setAmount((float) $membershipCost)
        ;
        $em->persist($membershipTrans);
        $transactions[] = $membershipTrans;

        $luncheons = $em->getRepository('UMRAMemberBundle:Luncheon')
                        ->findLatestLuncheons(7, true, new \DateTime("now"));

        foreach ($luncheons as $luncheon) {
            $trans = new Trans();
            $trans->setPerson($member)
                  ->setTrantype("LUNCHEON_FEE")
                  ->setTrandate(new \DateTime("now"))
                  ->setStatus("AWAITING_PROCESS")
                  ->setPmtmethod($pmtMethod)
                  ->setAmount($luncheon->getPrice())
                  ->setLuncheon($luncheon)
            ;
            $em->persist($trans);

            $transactions[] = $trans;
        }

        $em->flush();

        return $transactions;
    }
}
