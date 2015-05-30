<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UMRA\Bundle\MemberBundle\Entity\Luncheon;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Entity\Trans;
use UMRA\Bundle\MemberBundle\Form\LuncheonType;
use UMRA\Bundle\MemberBundle\Form\LuncheonRegistrationType;

/**
 * Luncheon controller.
 *
 */
class LuncheonController extends Controller
{

    /**
     * Lists all Luncheon entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UMRAMemberBundle:Luncheon')->findBy(
            array(),
            array('luncheonDate' => 'DESC')
        );

        return $this->render('UMRAMemberBundle:Luncheon:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Luncheon entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Luncheon();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Luncheon_show', array('id' => $entity->getId())));
        }

        return $this->render('UMRAMemberBundle:Luncheon:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Luncheon entity.
     *
     * @param Luncheon $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Luncheon $entity)
    {
        $form = $this->createForm(new LuncheonType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Luncheon_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Luncheon entity.
     *
     */
    public function newAction()
    {
        $entity = new Luncheon();
        $form   = $this->createCreateForm($entity);

        return $this->render('UMRAMemberBundle:Luncheon:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Luncheon entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Luncheon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Luncheon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UMRAMemberBundle:Luncheon:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Luncheon entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Luncheon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Luncheon entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UMRAMemberBundle:Luncheon:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Luncheon entity.
    *
    * @param Luncheon $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Luncheon $entity)
    {
        $form = $this->createForm(new LuncheonType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Luncheon_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Luncheon entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Luncheon')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Luncheon entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Luncheon_edit', array('id' => $id)));
        }

        return $this->render('UMRAMemberBundle:Luncheon:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Luncheon entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UMRAMemberBundle:Luncheon')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Luncheon entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Luncheon'));
    }

    /**
     * Creates a form to delete a Luncheon entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Luncheon_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }

    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        if (!$user instanceof Person) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $form = $this->createForm(new LuncheonRegistrationType(), null,
            array(
                'household' => $user->getHousehold(),
                'action'    => $this->generateUrl('UMRA_Luncheon_register')
            )
        );

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                if ($form->get('payCreditCard')->isClicked()) {
                    $pmtMethod = 'CREDIT_CARD';
                } else {
                    $pmtMethod = 'CHECK';
                }

                $formData = $form->getData();

                $luncheon = $formData['luncheon'];
                $members = $formData['members'];

                foreach ($members as $member) {
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

                // TODO: Handle payment transaction stuff

                return $this->redirect($this->generateUrl('UMRA_Person_Profile'));
            }
        }

        return $this->render('UMRAMemberBundle:Luncheon:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
