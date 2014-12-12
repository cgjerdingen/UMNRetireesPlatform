<?php

namespace UMRA\Bundle\MemberBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ResidenceAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('primary')
            ->add('address1')
            ->add('address2')
            ->add('address3')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('legdistrict')
            ->add('country')
            ->add('since')
            ->add('forseason')
            ->add('id')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('primary')
            ->add('address1')
            ->add('address2')
            ->add('address3')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('legdistrict')
            ->add('country')
            ->add('since', 'datetime', array('format' => 'm/d/Y'))
            ->add('forseason')
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
            ->add('primary')
            ->add('address1')
            ->add('address2')
            ->add('address3')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('legdistrict')
            ->add('country')
            ->add('since')
            ->add('forseason')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('primary')
            ->add('address1')
            ->add('address2')
            ->add('address3')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('legdistrict')
            ->add('country')
            ->add('since')
            ->add('forseason')
            ->add('id')
        ;
    }
}
