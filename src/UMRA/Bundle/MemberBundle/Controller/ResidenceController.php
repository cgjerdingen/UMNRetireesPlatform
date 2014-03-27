<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Residence;
use UMRA\Bundle\MemberBundle\Form\ResidenceType;

/**
 * Residence controller.
 *
 */
class ResidenceController extends Controller
{

    /**
     * Lists all Residence entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UMRAMemberBundle:Residence')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Residence entity.
     *
     * @Template("UMRAMemberBundle:Residence:new.html.twig")
     */
    public function createAction(Request $request, $householdId)
    {
        $entity = new Residence();
        $form = $this->createCreateForm($entity, $householdId);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $household = $em->getRepository('UMRAMemberBundle:Household')->find($householdId);

        if (!$household) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        if ($form->isValid()) {
            $entity->setHousehold($household);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Residence_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'household' => $household
        );
    }

    /**
    * Creates a form to create a Residence entity.
    *
    * @param Residence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Residence $entity, $householdId)
    {
        $form = $this->createForm(new ResidenceType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Household_Residence_create', array('householdId' => $householdId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Residence entity.
     *
     * @Template()
     */
    public function newAction($householdId)
    {
        $entity = new Residence();
        $form   = $this->createCreateForm($entity, $householdId);

        $em = $this->getDoctrine()->getManager();

        $household = $em->getRepository('UMRAMemberBundle:Household')->find($householdId);

        if (!$household) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'household' => $household
        );
    }

    /**
     * Finds and displays a Residence entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Residence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Residence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Residence entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Residence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Residence entity.');
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
    * Creates a form to edit a Residence entity.
    *
    * @param Residence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Residence $entity)
    {
        $form = $this->createForm(new ResidenceType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Residence_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Residence entity.
     *
     * @Template("UMRAMemberBundle:Residence:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Residence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Residence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Residence_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Residence entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UMRAMemberBundle:Residence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Residence entity.');
        }

        $hid = $entity->getHousehold()->getId();

        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $hid)));
    }

    /**
     * Creates a form to delete a Residence entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Residence_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
