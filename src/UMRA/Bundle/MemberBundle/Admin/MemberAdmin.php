<?php

namespace UMRA\Bundle\MemberBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MemberAdmin extends Admin
{
    protected $baseRouteName = 'admin_umra_member';
    protected $baseRoutePattern = 'member';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
           ->add('lastname', 'text', array(
                    'label' => 'Last Name'
                ))
            ->add('firstname', 'text', array(
                    'label' => 'First Name'
                ))
            ->add('nickname', 'text', array(
                    'label' => 'Nickname'
                ))
            ->add('fullname', 'text', array(
                    'label' => 'Full Name'
                ))
            ->add('nametagname', 'text', array(
                    'label' => 'Nametag Name'
                ))
            ->add('membersince', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'UMRA Member Since',
                    'required' => false
                ))
            ->add('utopunit', 'text', array(
                    'label' => 'University Unit',
                    'required' => false
                ))
            ->add('udeptequiv', 'text', array(
                    'label' => 'University Department',
                    'required' => false
                ))
            ->add('uempltype', 'choice', array(
                    'choices' => array(
                        'faculty' => 'Faculty',
                        'acad_prof' => 'Academic Professional',
                        'acad_adm' => 'Academic Administrator',
                        'civ_srv' => 'Civil Service',
                        'afscme_cler' => 'AFSCME Clerical',
                        'afscme_tech' => 'AFSCME Technical',
                        'teamster' => 'Teamster'
                    ),
                    'label' => 'Employment Type',
                    'required' => false
                ))
            ->add('utitle', 'text', array(
                    'label' => 'Title',
                    'required' => false
                ))
            ->add('ustartdate', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'University Start Date',
                    'required' => false
                ))
            ->add('uretiredate', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'University Retire Date',
                    'required' => false
                ))
            ->add('deceasedate', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'Deceased Date',
                    'required' => false
                ))
            ->add('activenow', 'checkbox', array(
                    'label' => 'Active',
                    'required' => false
                ))
            ->add('newsPref', 'choice', array(
                    'choices' => array(
                        'postal' => 'Postal Mail',
                        'email' => 'Email',
                        'both' => 'Both'
                    ),
                    'label' => 'Newsletter Preference',
                    'expanded' => true,
                    'required' => false
                ))
            ->add('weburl', 'url', array(
                    'label' => 'Personal Website',
                    'required' => false,
                    'attr' => array('placeholder' => 'e.g. http://umn.edu/~test001/')
                ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('lastname')
            ->add('firstname')
            ->add('utopunit')
            ->add('udeptequiv')
            ->add('uempltype')
            ->add('membersince')
            ->add('activenow')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullname')
            ->add('membersince')
            ->add('activenow')
        ;
    }
}
