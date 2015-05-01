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

class RegistrationController extends Controller
{
    const LUNCHEON_P_BEGIN = "first day of September";
    const LUNCHEON_P_END = "first day of April next year";

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

                // Persist each user.
                foreach ($formData['members'] as $key => $member) {
                    $emailCanonical = $member->getEmailCanonical();

                    if (!empty($emailCanonical)) {
                        $email = new Email();
                        $email->setType("personal");
                        $email->setPreferred(true);
                        $email->setPerson($member);
                        $email->setEmail($emailCanonical);
                        $em->persist($email);

                        $member->setEmailCanonical($emailCanonical);
                        $member->setConfirmationToken($tokenGenerator->generateToken());

                        $memberEmails[] = $emailCanonical;
                    }

                    if (function_exists("openssl_random_pseudo_bytes")) {
                        $member->setPlainPassword(openssl_random_pseudo_bytes(12));
                    } else {
                        // Less than secure randomized password generation
                        // Luckily, plainPassword gets bcrypt()'d
                        $logger->warning("OpenSSL extension not loaded." .
                                         "Falling back to using uniqid() for ranomized plain-text password generation." .
                                         "Password will still be hashed.");
                        $member->setPlainPassword(uniqid(mt_rand()));
                    }

                    $member->setHousehold($household)
                           ->setActivenow(false)
                    ;
                    $userManager->updateUser($member, true);
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

                // Determine payment method.
                if ($form->get('payCreditCard')->isClicked()) {
                    $pmtMethod = 'CREDIT_CARD';
                } else {
                    $pmtMethod = 'CHECK';
                }

                // TODO: Payment

                // TODO: After return from payment processor. Probably will get moved
                $this->processMembershipTransactions(
                    $em, $member, $membershipStatus, $pmtMethod,
                    $formData['membershipType'], $formData['luncheonPreorder']
                );

                for ($i = 0; $i < count($memberEmails); $i++) {
                    $user = $userManager->findUserByEmail($memberEmails[$i]);
                    $userMailer->sendResettingEmailMessage($user);
                }

                return $this->render('UMRAMemberBundle:Registration:register_thanks.html.twig', array());
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
                $this->processMembershipTransactions($em, $user, "MEMBERSHIP_RENEW", $pmtMethod, $formData['membershipType'], $formData['luncheonPreorder']);

                return $this->render('UMRAMemberBundle:Registration:register_thanks.html.twig', array());
            }
        }

        return $this->render('UMRAMemberBundle:Registration:renew.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function processMembershipTransactions($em, Person $member, $tranType, $pmtMethod, $membershipCost, $luncheonCost)
    {
        // Create tranaction for membership fee.
        $membershipTrans = new Trans();
        $membershipTrans->setPerson($member)
                        ->setTrantype($tranType)
                        ->setTrandate(new \DateTime("now"))
                        ->setPmtmethod($pmtMethod)
                        ->setAmount((float) $membershipCost)
        ;
        $em->persist($membershipTrans);


        $luncheonPeriodBegin = new \DateTime(self::LUNCHEON_P_BEGIN);
        $luncheonPeriodEnd = new \DateTime(self::LUNCHEON_P_END);

        $luncheonCount = $luncheonPeriodEnd->diff($luncheonPeriodBegin)
                                                ->format("%m");

        $singleLuncheonCost = (float) $luncheonCost / $luncheonCount;


        $luncheonPeriod = new \DatePeriod($luncheonPeriodBegin, new \DateInterval('P1M'), $luncheonPeriodEnd);

        // Create a transaction for each luncheon
        foreach($luncheonPeriod as $luncheonMonth) {
            $trans = new Trans();
            $trans->setPerson($member)
                  ->setTrantype("LUNCHEON_FEE")
                  ->setTrandate(new \DateTime("now"))
                  ->setPmtmethod($pmtMethod)
                  ->setAmount($singleLuncheonCost)
                  ->setDateFor($luncheonMonth)
            ;
            $em->persist($trans);
        }

        $em->flush();
    }
}
