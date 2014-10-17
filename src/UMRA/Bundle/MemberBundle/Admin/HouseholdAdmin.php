<?php

namespace UMRA\Bundle\MemberBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class HouseholdAdmin extends Admin
{
    protected $baseRouteName = 'admin_umra_household';
    protected $baseRoutePattern = 'household';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General Information')
                ->add('lastname')
                ->add('firstname')
                ->add('postalname')
            ->end()
            ->with('Members/People')
                ->add('persons')
            ->end()
            ->with('Residences')
                ->add('residences')
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('postalname', null, array('label' => 'Postal Name'))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('General Information')
                ->add('lastname')
                ->add('firstname')
                ->add('postalname')
            ->end()
            ->with('Members/People')
                ->add('persons')
            ->end()
            ->with('Residences')
                ->add('residences')
            ->end()
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('lastname', null, array('label' => 'Last Name'))
            ->add('firstname', null, array('label' => 'First Name'))
            ->add('postalname', null, array('label' => 'Postal Name'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}
