<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Form\PersonType;
use UMRA\Bundle\MemberBundle\Form\RenewalType;
use UMRA\Bundle\MemberBundle\Form\LuncheonRegistrationType;

/**
 * Person controller.
 *
 */
class PersonController extends Controller
{

    /**
     * Lists all Person entities.
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if (!$securityContext->isGranted('ROLE_CAN_VIEW_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $em = $this->getDoctrine()->getManager();

        $searchTerm = $request->query->get('q');
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);

        if (!empty($searchTerm)) {
            $entities = $em->getRepository('UMRAMemberBundle:Person')->findBySearchTerms($searchTerm, $page, $limit);
        } else {
            $entities = array();
        }

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Person entity.
     *
     * @Template("UMRAMemberBundle:Person:new.html.twig")
     */
    public function createAction(Request $request, $householdId)
    {
        $entity = new Person();
        $form = $this->createCreateForm($entity, $householdId);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $household = $em->getRepository('UMRAMemberBundle:Household')->find($householdId);

        if (!$household) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if ($authedUser->getHousehold()->getId() !== $household->getId() &&
            !$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $userManager = $this->container->get('fos_user.user_manager');

        if ($form->isValid()) {
            // Set to some random value. If we're adding from the records pages, we're not the person in question.
            // Therfore, we don't need a known password (yet). The user may reset it later.
            $plainPassword = $entity->getPlainPassword();
            if(empty($plainPassword)) {
                $entity->setPlainPassword(uniqid(mt_rand()));
            }
            $entity->setHousehold($household);
            $userManager->updateUser($entity, true); // Create user & password. Flush changes.

            return $this->redirect($this->generateUrl('UMRA_Person_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'household' => $household
        );
    }

    /**
    * Creates a form to create a Person entity.
    *
    * @param Person $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Person $entity, $householdId)
    {
        $form = $this->createForm(new PersonType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Household_Person_create', array('householdId' => $householdId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Person entity.
     *
     * @Template()
     */
    public function newAction($householdId)
    {
        $entity = new Person();
        $form   = $this->createCreateForm($entity, $householdId);

        $em = $this->getDoctrine()->getManager();

        $household = $em->getRepository('UMRAMemberBundle:Household')->find($householdId);

        if (!$household) {
            throw $this->createNotFoundException('Unable to find Household entity.');
        }

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if ($authedUser->getHousehold()->getId() !== $household->getId() &&
            !$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'household' => $household
        );
    }

    /**
     * Finds and displays a Person entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if ((int)$id !== $authedUser->getId() &&
            $authedUser->getHousehold()->getId() !== $entity->getHousehold()->getId() &&
            !$securityContext->isGranted('ROLE_CAN_VIEW_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Person entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if ((int)$id !== $authedUser->getId() &&
            $authedUser->getHousehold()->getId() !== $entity->getHousehold()->getId() &&
            !$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
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
     * Controller action for displaying a user dashboard
     * from which they can view and edit information pertaining
     * to them.
     *
     * @Template("UMRAMemberBundle:Person:profile.html.twig")
     */
    public function profileAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if (!$user instanceof Person) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $profileForm = $this->get('fos_user.profile.form');
        $changePasswordForm = $this->get('fos_user.change_password.form');
        $luncheonForm = $form = $this->createForm(new LuncheonRegistrationType(), null,
            array(
                'household' => $user->getHousehold(),
                'action'    => $this->generateUrl('UMRA_Luncheon_register')
            )
        );
        $renewalForm = $this->createForm(new RenewalType());

        return array(
            'user' => $user,
            'profileForm' => $profileForm->createView(),
            'changePasswordForm' => $changePasswordForm->createView(),
            'luncheonForm' => $luncheonForm->createView(),
            'renewalForm' => $renewalForm->createView()
        );
    }

    /**
    * Creates a form to edit a Person entity.
    *
    * @param Person $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Person $entity)
    {
        $form = $this->createForm(new PersonType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Person_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if (!$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_PERSON')) {
            $form->remove('memberSince');
            $form->remove('activenow');

            if ($entity->getId() !== $authedUser->getId() &&
                $authedUser->getHousehold()->getId() !== $entity->getHousehold()->getId()) {
                $form->remove('plainPassword');
            }
        }

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Person entity.
     *
     * @Template("UMRAMemberBundle:Person:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if ((int)$id !== $authedUser->getId() &&
            $authedUser->getHousehold()->getId() !== $entity->getHousehold()->getId() &&
            !$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($entity, true);

            return $this->redirect($this->generateUrl('UMRA_Person_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Person entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('UMRAMemberBundle:Person')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Person entity.');
        }

        $hid = $entity->getHousehold()->getId();

        $securityContext = $this->get('security.context');
        $authedUser = $securityContext->getToken()->getUser();

        if ((int)$id === $authedUser->getId() && // Authed user cannot delete themselves
            $authedUser->getHousehold()->getId() !== $entity->getHousehold()->getId() &&
            !$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_PERSON')) {
            throw new AccessDeniedException('You do not have access to this page. Please login.');
        }


        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Household_show', array('id' => $hid)));
    }

    /**
     * Creates a form to delete a Person entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Person_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
