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
    const LUNCHEON_COUNT = 7;

    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $household = new Household();
        $email = new Email();
        $email->setPreferred(true);
        $form = $this->createForm(new RegistrationFormType(), array(
            'household' => $household,
            'members' => array(new Person()),
            'primaryEmail' => $email,
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

                // Persist each user.
                foreach ($formData['members'] as $key => $member) {
                    if ($key === 0) {
                        $member->setConfirmationToken($tokenGenerator->generateToken());
                        $member->setEmailCanonical($email->getEmail());
                        $email->setPerson($member);
                        $em->persist($email);
                    }
                    // This is getting hashed, so it's okay to use mt_rand, despite its shortcomings.
                    $member->setPlainPassword(uniqid(mt_rand()))
                           ->setHousehold($household)
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

                $this->processMembershipTransactions(
                    $em, $member, $membershipStatus, $pmtMethod,
                    $formData['membershipType'], $formData['luncheonPreorder']
                );

                $primaryUser = $userManager->findUserByEmail($email->getEmail());

                $userMailer->sendResettingEmailMessage($primaryUser);

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

        $singleLuncheonCost = (float) $luncheonCost / self::LUNCHEON_COUNT;

        // Create a transaction for each luncheon
        for ($i = 0; $i < self::LUNCHEON_COUNT; $i++) {
            $trans = new Trans();
            $trans->setPerson($member)
                  ->setTrantype("LUNCHEON_FEE")
                  ->setTrandate(new \DateTime("now"))
                  ->setPmtmethod($pmtMethod)
                  ->setAmount($singleLuncheonCost)
                  ->setNotes(sprintf("%d/%d prepaid luncheon fee", $i+1, self::LUNCHEON_COUNT))
            ;
            $em->persist($trans);
        }

        $em->flush();
    }
}
