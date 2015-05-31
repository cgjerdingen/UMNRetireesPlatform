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

        $luncheons = $em->getRepository('UMRAMemberBundle:Luncheon')
                        ->findLatestLuncheons(7, true, new \DateTime("now"));

        foreach ($luncheons as $luncheon) {
            $trans = new Trans();
            $trans->setPerson($member)
                  ->setTrantype("LUNCHEON_FEE")
                  ->setTrandate(new \DateTime("now"))
                  ->setPmtmethod($pmtMethod)
                  ->setAmount($luncheon->getPrice())
                  ->setLuncheon($luncheon)
            ;
            $em->persist($trans);
        }

        $em->flush();
    }
}
