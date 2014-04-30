<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Phone;
use UMRA\Bundle\MemberBundle\Form\PhoneType;

/**
 * Phone controller.
 *
 */
class PhoneController extends Controller
{

    /**
     * Lists all Phone entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UMRAMemberBundle:Phone')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Phone entity.
     *
     * @Template("UMRAMemberBundle:Phone:new.html.twig")
     */
    public function createAction(Request $request, $personId = null, $residenceId = null)
    {
        $entity = new Phone();
        $form = $this->createCreateForm($entity, $personId, $residenceId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($personId) {
                $person = $em->getRepository('UMRAMemberBundle:Person')->find($personId);
                if (!$person) {
                    throw $this->createNotFoundException();
                }
                $entity->setPerson($person);
                $hid = $person->getHousehold()->getId();
            } elseif ($residenceId) {
                $residence = $em->getRepository('UMRAMemberBundle:Residence')->find($residenceId);
                if (!$residence) {
                    throw $this->createNotFoundException();
                }
                $entity->setResidence($residence);
                $hid = $residence->getHousehold()->getId();
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $hid)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Phone entity.
    *
    * @param Phone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Phone $entity, $personId = null, $residenceId = null)
    {
        if ($residenceId != null && $personId === null) {
            $entity->setPhtype('shared');
            $form = $this->createForm(new PhoneType(), $entity, array(
                'action' => $this->generateUrl('UMRA_Residence_Phone_create', array('residenceId' => $residenceId)),
                'method' => 'POST',
            ));
            $form->remove('phtype');
        } else {
            $form = $this->createForm(new PhoneType(), $entity, array(
                'action' => $this->generateUrl('UMRA_Person_Phone_create', array('personId' => $personId)),
                'method' => 'POST',
            ));
        }

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Phone entity.
     *
     * @Template()
     */
    public function newAction($personId = null, $residenceId = null)
    {
        $entity = new Phone();
        $form   = $this->createCreateForm($entity, $personId, $residenceId);

        $em = $this->getDoctrine()->getManager();

        if ($personId) {
            $person = $em->getRepository('UMRAMemberBundle:Person')->find($personId);
            if (!$person) {
                throw $this->createNotFoundException();
            }
            $householdId = $person->getHousehold()->getId();
        } else {
            $residence = $em->getRepository('UMRAMemberBundle:Residence')->find($residenceId);
            if (!$residence) {
                throw $this->createNotFoundException();
            }
            $householdId = $residence->getHousehold()->getId();
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'householdId' => $householdId,
        );
    }

    /**
     * Finds and displays a Phone entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getResidence()->getHousehold()->getId();
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'householdId' => $householdId,
        );
    }

    /**
     * Displays a form to edit an existing Phone entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
            $residenceId = null;
        } else {
            $householdId = $entity->getResidence()->getHousehold()->getId();
            $residenceId = $entity->getResidence()->getId();
        }

        $editForm = $this->createEditForm($entity, $residenceId);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'householdId' => $householdId,
        );
    }

    /**
    * Creates a form to edit a Phone entity.
    *
    * @param Phone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Phone $entity, $residenceId = null)
    {
        $form = $this->createForm(new PhoneType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Phone_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        if ($residenceId != null && $entity->getPerson() == null) {
            $form->remove('phtype');
        }

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Phone entity.
     *
     * @Template("UMRAMemberBundle:Phone:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getResidence()->getHousehold()->getId();
            $residenceId = $entity->getResidence()->getId();
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $residenceId);
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
     * Deletes a Phone entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Phone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Phone entity.');
        }

        if ($entity->getPerson()) {
            $householdId = $entity->getPerson()->getHousehold()->getId();
        } else {
            $householdId = $entity->getResidence()->getHousehold()->getId();
        }

        if ($form->isValid()) {

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $householdId)));
    }

    /**
     * Creates a form to delete a Phone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Phone_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
