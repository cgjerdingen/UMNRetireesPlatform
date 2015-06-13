<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use UMRA\Bundle\MemberBundle\Entity\ContentBlock;
use UMRA\Bundle\MemberBundle\Form\ContentBlockType;

/**
 * ContentBlock controller.
 *
 */
class ContentBlockController extends Controller
{

    /**
     * Lists all ContentBlock entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UMRAMemberBundle:ContentBlock')->findAll();

        return $this->render('UMRAMemberBundle:ContentBlock:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to edit an existing ContentBlock entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:ContentBlock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentBlock entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('UMRAMemberBundle:ContentBlock:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ContentBlock entity.
    *
    * @param ContentBlock $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContentBlock $entity)
    {
        $form = $this->createForm(new ContentBlockType(), $entity, array(
            'action' => $this->generateUrl('UMRA_ContentBlock_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing ContentBlock entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:ContentBlock')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ContentBlock entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_ContentBlock_edit', array('id' => $id)));
        }

        return $this->render('UMRAMemberBundle:ContentBlock:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
