<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Email;
use UMRA\Bundle\MemberBundle\Form\EmailType;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Form\PersonType;

/**
 * Email controller.
 *
 */
class EmailController extends Controller
{

    /**
     * Lists all Email entities.
     *
     * @Template()
     */
    public function indexAction($personId)
    {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UMRAMemberBundle:Email')->findBy(
			array('person' => $personId)
		);

        $person_entity = $em->getRepository('UMRAMemberBundle:Person')->find($personId);

        if (!$person_entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        return array(
            'entities' => $entities, 'personId' => $personId, 'person_entity' => $person_entity,
        );
    }
    /**
     * Creates a new Email entity.
     *
     * @Template("UMRAMemberBundle:Email:new.html.twig")
     */
    public function createAction(Request $request, $personId = null, $householdId = null)
    {
        $entity = new Email();

        $form = $this->createCreateForm($entity, $personId, $householdId);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();


        if ($personId) {
            $person = $em->getRepository('UMRAMemberBundle:Person')->find($personId);
            if (!$person) {
                throw $this->createNotFoundException();
            }
            $entity->setPerson($person);
            $hid = $person->getHousehold()->getId();
        } elseif ($householdId) {
            $household = $em->getRepository('UMRAMemberBundle:Household')->find($householdId);
            if (!$household) {
                throw $this->createNotFoundException();
            }
            $entity->setHousehold($household);
            $hid = $householdId;
        }

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $hid)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'householdId' => $hid
        );
    }

    /**
    * Creates a form to create a Email entity.
    *
    * @param Email $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Email $entity, $personId = null, $householdId = null)
    {
        if ($householdId != null && $personId === null) {
            $entity->setType('shared');
            $form = $this->createForm(new EmailType(), $entity, array(
                'action' => $this->generateUrl('UMRA_Household_Email_create', array('householdId' => $householdId)),
                'method' => 'POST',
            ));
            $form->remove('type');
        } else {
            $form = $this->createForm(new EmailType(), $entity, array(
                'action' => $this->generateUrl('UMRA_Person_Email_create', array('personId' => $personId)),
                'method' => 'POST',
            ));
        }

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Email entity for a given person.
     *
     * @Template()
     */
    public function newAction($personId = null, $householdId = null)
    {
        $entity = new Email();
        $form   = $this->createCreateForm($entity, $personId, $householdId);

        if ($personId) {
            $person = $this->getDoctrine()->getManager()
                        ->getRepository('UMRAMemberBundle:Person')->find($personId);
            if (!$person) {
                throw $this->createNotFoundException();
            }
            $householdId = $person->getHousehold()->getId();
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'householdId' => $householdId,
        );
    }

    /**
     * Finds and displays a Email entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getHousehold()->getId();
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'householdId' => $householdId,
        );
    }

    /**
     * Displays a form to edit an existing Email entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getHousehold()->getId();
        }

        $editForm = $this->createEditForm($entity, $householdId);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'householdId' => $householdId,
        );
    }

    /**
    * Creates a form to edit a Email entity.
    *
    * @param Email $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Email $entity, $householdId = null)
    {
        $form = $this->createForm(new EmailType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Email_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        if ($householdId != null && $entity->getPerson() == null) {
            $form->remove('type');
        }

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Email entity.
     *
     * @Template("UMRAMemberBundle:Email:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getHousehold()->getId();
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $householdId);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $householdId)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'householdId' => $householdId,
        );
    }
    /**
     * Deletes a Email entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getHousehold()->getId();
        }

        if ($form->isValid()) {

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $householdId)));
    }

    /**
     * Creates a form to delete a Email entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Email_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
