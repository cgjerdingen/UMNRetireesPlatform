<?php

namespace UMRA\Bundle\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UMRA\Bundle\MemberBundle\Entity\Person;
use UMRA\Bundle\MemberBundle\Entity\Trans;
use UMRA\Bundle\MemberBundle\Form\TransFilterType;
use UMRA\Bundle\MemberBundle\Form\TransType;
use UMRA\Bundle\MemberBundle\Services\PayPalApiService;

use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

/**
 * Trans controller.
 *
 */
class TransController extends Controller
{
    /**
     * Lists all Trans entities.
     *
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create(new TransFilterType());

        if ($request->query->has($form->getName())) {
            $form->submit($request->query->get($form->getName()));

            $filterBuilder = $em->getRepository('UMRAMemberBundle:Trans')
                                ->createQueryBuilder('t')
                                ->orderBy('t.trandate', 'DESC');

            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($form, $filterBuilder);

            $query = $filterBuilder->getQuery();
        } else {
            $query = $em->getRepository('UMRAMemberBundle:Trans')->queryAll();
        }

        $paginator  = $this->get('knp_paginator');

        $entities = $paginator->paginate($query, $request->query->get('page', 1), 25);

        return array(
            'entities' => $entities,
            'form' => $form->createView(),
        );
    }
    /**
     * Creates a new Trans entity.
     *
     * @Template("UMRAMemberBundle:Trans:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Trans();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Trans_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Trans entity.
    *
    * @param Trans $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Trans $entity)
    {
        $form = $this->createForm(new TransType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Trans_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }

    /**
     * Displays a form to create a new Trans entity.
     *
     * @Template()
     */
    public function newAction()
    {
        $entity = new Trans();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Trans entity.
     *
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Trans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trans entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Trans entity.
     *
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Trans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trans entity.');
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
    * Creates a form to edit a Trans entity.
    *
    * @param Trans $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Trans $entity)
    {
        $form = $this->createForm(new TransType(), $entity, array(
            'action' => $this->generateUrl('UMRA_Trans_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary')));

        return $form;
    }
    /**
     * Edits an existing Trans entity.
     *
     * @Template("UMRAMemberBundle:Trans:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Trans')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Trans entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('UMRA_Trans_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Trans entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UMRAMemberBundle:Trans')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Trans entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('UMRA_Trans'));
    }

    /**
     * Creates a form to delete a Trans entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('UMRA_Trans_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }

    public function reconcileAction(Request $request) {
        $securityContext = $this->get('security.context');

        if (!$securityContext->isGranted('ROLE_CAN_EDIT_OTHER_TRANSACTION')) {
            throw new AccessDeniedException('You do not have access to this page. Either you are not logged in or you do not have permissions to view this page');
        }

        $authedUser = $securityContext->getToken()->getUser();

        $id = $request->request->getInt('id');

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UMRAMemberBundle:Trans')->find($id);

        if (!$entity instanceof Trans) {
            throw $this->createNotFoundException('Unable to find transaction.');
        }

        $entity->setDoneBy($authedUser);
        $entity->setStatus("PROCESSED");
        $entity->setReconciledDate(new \DateTime("now"));
        $em->persist($entity);
        $em->flush();

        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatusCode(Response::HTTP_NO_CONTENT);
        $response->prepare($request);
        return $response->send();
    }

    public function paypalCallbackSuccessAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $config = array(
            'client_id'     => $this->container->getParameter('paypal_client_id'),
            'client_secret' => $this->container->getParameter('paypal_client_secret'),
            'environment'   => $this->container->getParameter('paypal_environment')
        );

        $apiContext = PayPalApiService::getApiContext($config);

        $paymentId = $request->query->get('paymentId');
        $payerId = $request->query->get('PayerID');

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        $result = $payment->execute($execution, $apiContext);

        $payment = Payment::get($paymentId, $apiContext);

        $ppTrans = $payment->getTransactions();

        $transactions = array();

        foreach ($ppTrans as $ppTran)
        {
            $umraTrans = $em->getRepository("UMRAMemberBundle:Trans")
                            ->findBy(array("invoiceId" => $ppTran->getInvoiceNumber()));

            foreach ($umraTrans as $trans)
            {
                $procId = $result
                  ->getTransactions()[0]
                  ->getRelatedResources()[0]
                  ->getSale()
                  ->getId();

                $transType = $trans->getTrantype();

                // If membership renewal, update activenow
                if ($transType === "MEMBERSHIP_NEW" || $transType === "MEMBERSHIP_RENEW")
                {
                    $person = $trans->getPerson();

                    if ($person instanceof Person) {
                        $person->setActivenow(true);
                        $em->persist($person);
                    }
                }

                $trans->setProcTranId($procId)
                      ->setStatus("PROCESSED")
                      ->setReconciledDate(new \DateTime("now"));

                $em->persist($trans);

                $transactions[] = $trans;
            }
        }

        $em->flush();

        return $this->render('UMRAMemberBundle:Registration:register_thanks.html.twig', array(
            'transactions' => $transactions
        ));
    }

    public function paypalCallbackCancelAction()
    {
        return $this->render('UMRAMemberBundle:Registration:canceled.html.twig');
    }
}
