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

                $formData = $form->getData();

                // Persist household.
                $em->persist($household);
                $em->flush();

                // Persist each user.
                foreach ($formData['members'] as $key => $member) {
                    if ($key === 0) {
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

                // Create tranaction for membership fee.
                $membershipTrans = new Trans();
                $membershipTrans->setPerson($member)
                                ->setTrantype($membershipStatus)
                                ->setTrandate(new \DateTime("now"))
                                ->setPmtmethod($pmtMethod)
                                ->setAmount((float) $formData['membershipType'])
                ;
                $em->persist($membershipTrans);

                $singleLuncheonCost = (float) $formData['luncheonPreorder'] / self::LUNCHEON_COUNT;

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

                $primaryUser = $userManager->findUserByEmail($email->getEmail());

                $this->get('fos_user.mailer')->sendResettingEmailMessage($primaryUser);

                //TODO: Some stuff with payment processing and transaction handling & emailing password reset link.

                return $this->render('UMRAMemberBundle:Registration:register_thanks.html.twig', array());
            }
        }

        return $this->render('UMRAMemberBundle:Registration:register.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function renewAction()
    {
    }

}
