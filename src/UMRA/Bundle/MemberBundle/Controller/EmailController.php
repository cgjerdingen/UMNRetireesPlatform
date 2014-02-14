<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Email;
use UMRA\Bundle\MemberBundle\Form\EmailType;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Form\PersonType;

/**
 * Email controller.
 *
 * @Route("/UMRA/Email")
 */
class EmailController extends Controller
{

    /**
     * Lists all Email entities.
     *
     * @Route("/{personId}", name="UMRA_Email")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($personId)
    {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UMRAMemberBundle:Email')->findBy(
			array('personid' => $personId)
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
     * @Route("/Emailcreate/{personId}", name="UMRA_Email_create")
     * @Method("POST")
     * @Template("UMRAMemberBundle:Email:new.html.twig")
     */
    public function createAction(Request $request, $personId)
    {
        $entity = new Email();
        $form = $this->createCreateForm($entity, $personId);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('UMRA_Email', array('personId' => $entity->getPersonid()->getId())));
            // return $this->redirect($this->generateUrl('UMRA_Email', array('personId' => $personId)));
            // return $this->redirect($this->generateUrl('UMRA_Email_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Email entity.
    *
    * @param Email $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Email $entity, $personId)
    {
        $form = $this->createForm(new EmailType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Email_create', array('personId' => $personId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Email entity for a given person.
     *
     * @Route("/new/{personId}", name="UMRA_Email_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($personId)
    {
        $entity = new Email();
        $form   = $this->createCreateForm($entity, $personId);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'personId' => $personId,
        );
    }

    /**
     * Finds and displays a Email entity.
     *
     * @Route("/{id}", name="UMRA_Email_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Email entity.
     *
     * @Route("/{id}/edit", name="UMRA_Email_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'personId' => $entity->getPersonid()->getId(),
        );
    }

    /**
    * Creates a form to edit a Email entity.
    *
    * @param Email $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Email $entity)
    {
        $form = $this->createForm(new EmailType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Email_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Email entity.
     *
     * @Route("UMRA/Emailupdate/{id}", name="UMRA_Email_update")
     * @Method("PUT")
     * @Template("UMRAMemberBundle:Email:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Email entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Email_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Email entity.
     *
     * @Route("/URMA/Emaildelete/{id}", name="UMRA_Email_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UMRAMemberBundle:Email')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Email entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Email', array('personId' => $entity->getPersonid()->getId())));
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
