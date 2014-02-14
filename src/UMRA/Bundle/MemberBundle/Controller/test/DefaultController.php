<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use UMRA\Bundle\MemberBundle\Entity\MemberList;
use UMRA\Bundle\MemberBundle\Entity\Member;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
    	$member = new Member();
    	$em = $this->getDoctrine()->getEntityManager();
    	$em->persist($member);

    	$form = $this->createFormBuilder($member)
    		->add('FirstName', 'text')
    		->add('LastName', 'text')
    		->add('FullName', 'text')
    		->add('MailName', 'text')
    		->add('LabelName', 'text')
    		->add('SSOFullName', 'text')
    		->add('MemberSince', 'text')
    		->add('UtopUnit', 'text')
    		->add('UDeptEquiv', 'text')
    		->add('UEmplType', 'text')
    		->add('UTitle', 'text')
    		->add('UStartDate', 'text')
    		->add('URetireDate', 'text')
    		->add('JoinDate', 'text')
    		->add('DeceasedDate', 'text')
    		->add('MailNewsLetter','choice', array(
    			'choices' => array(
    				'no',
    				'yes'
    				),
    			'multiple' => false,
    			'expanded' => false
    			)
    		)
    		->add('WebPage', 'text')
    		->add('Comment', 'text')
    		->add('PartnerMemberID', 'text')
    		->getForm();

    		if ($request->getMethod() == 'POST') {
    			$form->bindRequest($request);

    			if ($form->isValid()) {
    				// perform some action, such as saving the task to the database
    				$em->flush();

    				return $this->redirect($this->gerenateUrl('task_success'));
    			}
    		}




        return $this->render('UMRAMemberBundle:Default:index.html.twig', array('form' => $form->createView() )); 
   
    }

    public function showAction()
    {
    	$member = $this->getDoctrine()
    		->getRepository('UMRAMemberBundle:Member')
    		->findAll();

    		if(!$member) {
    			throw $this->createNotFoundException(
    				'None found: Error Processing Request'
    				);
    			
    		}
    	return $this->render('UMRAMemberBundle:Default:show.html.twig', array('member' => $member)); 
    }
}
