<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Residence;
use UMRA\Bundle\MemberBundle\Form\ResidenceType;

/**
 * Residence controller.
 *
 * @Route("/UMRA/Residence")
 */
class ResidenceController extends Controller
{

    /**
     * Lists all Residence entities.
     *
     * @Route("/", name="UMRA_Residence")
     * @Method("GET")
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
     * @Route("/", name="UMRA_Residence_create")
     * @Method("POST")
     * @Template("UMRAMemberBundle:Residence:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Residence();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Residence_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Residence entity.
    *
    * @param Residence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Residence $entity)
    {
        $form = $this->createForm(new ResidenceType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Residence_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Residence entity.
     *
     * @Route("/new", name="UMRA_Residence_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Residence();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Residence entity.
     *
     * @Route("/{id}", name="UMRA_Residence_show")
     * @Method("GET")
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
     * @Route("/{id}/edit", name="UMRA_Residence_edit")
     * @Method("GET")
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

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Residence entity.
     *
     * @Route("/{id}", name="UMRA_Residence_update")
     * @Method("PUT")
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
     * @Route("/{id}", name="UMRA_Residence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UMRAMemberBundle:Residence')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Residence entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Residence'));
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
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
