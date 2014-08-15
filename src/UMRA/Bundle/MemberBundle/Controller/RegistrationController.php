<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UMRA\Bundle\MemberBundle\Entity\Email;
use UMRA\Bundle\MemberBundle\Entity\Household;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Entity\Residence;
use UMRA\Bundle\MemberBundle\Form\RegistrationFormType;

class RegistrationController extends Controller
{
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

            if ($form->isValid()) {
                $userManager = $this->container->get('fos_user.user_manager');

                $formData = $form->getData();

                $em->persist($household);
                $em->flush();

                foreach ($formData['members'] as $key => $member) {
                    if ($key === 0) {
                        $member->setEmailCanonical($email->getEmail());
                        $email->setPerson($member);
                        $em->persist($email);
                    }
                    $member->setPlainPassword(uniqid(mt_rand()));
                    $member->setHousehold($household);
                    $userManager->updateUser($member, true);
                }

                foreach ($formData['residences'] as $key => $res) {
                    $res->setHousehold($household);
                    $em->persist($res);
                }

                $em->flush();

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
