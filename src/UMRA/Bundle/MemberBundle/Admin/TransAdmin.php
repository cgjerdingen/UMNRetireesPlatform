<?php

namespace UMRA\Bundle\MemberBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TransAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('trandate', 'doctrine_orm_date', array('label' => 'Transaction Date'), 'date', array())
            ->add('trantype', null, array('label' => 'Transaction Type'))
            ->add('amount')
            ->add('pmtmethod', 'doctrine_orm_choice', array('label' => 'Payment Method'), 'choice', array(
                'choices' => array('CREDIT_CARD' => 'Credit Card', 'CHECK' => 'Check', 'OTHER' => 'Other')
            ))
            ->add('status', 'doctrine_orm_choice', array('label' => 'Transaction Status'), 'choice', array(
                'choices' => array('AWAITING_PROCESS' => 'Awaiting Process', 'PROCESSING' => 'Processing', 'PROCESSED' => 'Processed'),
            ))
            ->add('servicechg', null, array('label' => 'Service Charge'))
            ->add('doneby', null, array('label' => 'Done By'))
            ->add('dateFor', null, array('label' => 'Date For (Event Date, etc.)'))
            ->add('person')
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('trandate', 'datetime', array('label' => 'Transaction Date', 'format' => 'm/d/Y'))
            ->add('trantype', null, array('label' => 'Transaction Type'))
            ->add('status', null, array('label' => 'Transaction Status'))
            ->add('amount')
            ->add('pmtmethod', null, array('label' => 'Payment Method'))
            ->add('dateFor', null, array(
                'label' => 'Date For (Event Date, etc.)',
                'format' => 'M, Y'
            ))
            ->add('person')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('trandate', null, array('label' => 'Transaction Date'))
            ->add('trantype', 'choice', array(
                'label' => 'Transaction Type',
                'choices' => array('MEMBERSHIP_NEW' => 'New Membership', 'MEMBERSHIP_RENEW' => 'Membership Renewal', 'LUNCHEON_FEE' => 'Luncheon Fee', 'OTHER' => 'Other'),
                ))
            ->add('amount')
            ->add('pmtmethod', 'choice', array(
                'label' => 'Payment Method',
                'choices' => array('CREDIT_CARD' => 'Credit Card', 'CHECK' => 'Check', 'OTHER' => 'Other'),
                ))
            ->add('servicechg', null, array('label' => 'Service Charge'))
            ->add('status', 'choice', array(
                'label' => 'Transaction Type',
                'choices' => array('AWAITING_PROCESS' => 'Awaiting Process', 'PROCESSING' => 'Processing', 'PROCESSED' => 'Processed'),
                ))
            ->add('doneby')
            ->add('dateFor', null, array('label' => 'Date For (Event Date, etc.)'))
            ->add('reconciledDate', null, array('label' => 'Reconciled Date'))
            ->add('notes')
            ->add('person')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('trandate', null, array('label' => 'Transaction Date'))
            ->add('trantype', null, array('label' => 'Transaction Type'))
            ->add('amount')
            ->add('pmtmethod', null, array('label' => 'Payment Method'))
            ->add('servicechg', null, array('label' => 'Service Charge'))
            ->add('status')
            ->add('doneby', null, array('label' => 'Done By'))
            ->add('reconciledDate', null, array('label' => 'Reconciled Date'))
            ->add('dateFor', null, array(
                'label' => 'Date For (Event Date, etc.)',
                'format' => 'F, Y'
            ))
            ->add('person')
            ->add('notes')
            ->add('id')
        ;
    }
}
