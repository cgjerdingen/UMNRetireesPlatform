<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Household;
use UMRA\Bundle\MemberBundle\Form\HouseholdType;

/**
 * Household controller.
 *
 */
class HouseholdController extends Controller
{

    /**
     * Lists all Household entities.
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if (!$securityContext->isGranted('ROLE_CAN_VIEW_OTHER_HOUSEHOLD')) {
            throw new AccessDeniedException('You do not have access to this page. Either you are not logged in or you do not have permissions to view this page');
        }

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT h FROM UMRAMemberBundle:Household h ORDER BY h.lastname');

        $paginator  = $this->get('knp_paginator');

        $entities = $paginator->paginate($query, $request->query->get('page', 1), 50);

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Household entity.
     *
     * @Template("UMRAMemberBundle:Household:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Household();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Household entity.
    *
    * @param Household $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Household $entity)
    {
        $form = $this->createForm(new HouseholdType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Household_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Household entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $entity = new Household();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Household entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Household')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Household entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Household')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Household entity.
    *
    * @param Household $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Household $entity)
    {
        $form = $this->createForm(new HouseholdType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Household_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Household entity.
     *
     * @Template("UMRAMemberBundle:Household:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Household')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Household_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Household entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UMRAMemberBundle:Household')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Household entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Household'));
    }

    /**
     * Creates a form to delete a Household entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Household_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete',  'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
