<?php

namespace UMRA\Bundle\MemberBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use UMRA\Bundle\MemberBundle\Form\EventListener\IndeterminateDateSubscriber;

class MemberAdmin extends Admin
{
    protected $baseRouteName = 'admin_umra_member';
    protected $baseRoutePattern = 'member';

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Personal Information')
                ->add('household')
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
                ->add('deceasedate', 'date', array(
                        'years' => range(1910, date('Y')),
                        'label' => 'Deceased Date',
                        'required' => false
                    ))
                ->add('weburl', 'url', array(
                        'label' => 'Personal Website',
                        'required' => false,
                        'attr' => array('placeholder' => 'e.g. http://umn.edu/~test001/')
                    ))
            ->end()
            ->with('University Information')
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
                ->add('ustartDayIndeterminate', 'hidden')
                ->add('ustartMonthIndeterminate', 'hidden')
                ->add('uretiredate', 'date', array(
                        'years' => range(1910, date('Y')),
                        'label' => 'University Retire Date',
                        'required' => false
                    ))
                ->add('uretireDayIndeterminate', 'hidden')
                ->add('uretireMonthIndeterminate', 'hidden')
            ->end()
            ->with('UMRA Information')
                ->add('membersince', 'date', array(
                        'years' => range(1910, date('Y')),
                        'label' => 'UMRA Member Since',
                        'required' => false
                    ))
                ->add('secondary', 'checkbox', array(
                        'label' => 'Secondary Member',
                        'required' => false
                    ))
                ->add('activenow', 'checkbox', array(
                        'label' => 'Active Membership',
                        'required' => false
                    ))
                ->add('newsPref', 'choice', array(
                        'choices' => array(
                            'postal' => 'Postal Mail',
                            'email' => 'Email',
                            'both' => 'Both'
                        ),
                        'label' => 'Newsletter Preference',
                        'expanded' => false,
                        'required' => false
                    ))
            ->end()
            ->with('Emails')
                ->add('emailCanonical', 'email', array('label' => 'Login Email Address'))
                ->add('emails')
            ->end()
            ->with('Phones')
                ->add('phones')
            ->end()
        ->getFormBuilder()
        ->addEventSubscriber(new IndeterminateDateSubscriber('membersince', 'membersinceMonthIndeterminate', 'membersinceDayIndeterminate'))
        ->addEventSubscriber(new IndeterminateDateSubscriber('ustartdate', 'ustartMonthIndeterminate', 'ustartDayIndeterminate'))
        ->addEventSubscriber(new IndeterminateDateSubscriber('uretiredate', 'uretireMonthIndeterminate', 'uretireDayIndeterminate'))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('Personal Information')
                ->add('household')
                ->add('lastname',  null, array(
                        'label' => 'Last Name'
                    ))
                ->add('firstname', null, array(
                        'label' => 'First Name'
                    ))
                ->add('nickname', null, array(
                        'label' => 'Nickname'
                    ))
                ->add('fullname', null, array(
                        'label' => 'Full Name'
                    ))
                ->add('nametagname', null, array('label' => 'Nametag Name'))
                ->add('deceasedate', null, array('label' => 'Deceased Date'))
                ->add('weburl', null, array('label' => 'Homepage URL'))
            ->end()
            ->with('University Information')
                ->add('utopunit', null, array('label' => 'University Unit'))
                ->add('udeptequiv', null, array('label' => 'University Department'))
                ->add('uempltype', null, array('label' => 'Employment Type'))
                ->add('utitle', null, array('label' => 'Job Title'))
                ->add('ustartdate', null, array('label' => 'University Start Date'))
                ->add('uretiredate', null, array('label' => 'University Retire Date'))
            ->end()
            ->with('UMRA Information')
                ->add('membersince', null, array('label' => 'UMRA Member Since'))
                ->add('secondary', null, array('label' => 'Secondary Member'))
                ->add('activenow', null, array('label' => 'Active'))
                ->add('newsPref', null, array('label' => 'Newsletter Preference'))
            ->end()
            ->with('Emails')
                ->add('emailCanonical', 'email', array('label' => 'Login Email Address'))
                ->add('emails')
            ->end()
            ->with('Phones')
                ->add('phones')
            ->end()
            ->with('Transactions')
                ->add('transactions')
            ->end()
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('lastname', null, array('label' => 'Last Name'))
            ->add('firstname', null, array('label' => 'First Name'))
            ->add('utopunit', null, array('label' => 'University Unit'))
            ->add('udeptequiv', null, array('label' => 'University Department'))
            ->add('uempltype', 'doctrine_orm_choice', array('label' => 'Employment Type'), 'choice', array(
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
            ->add('membersince', 'doctrine_orm_date', array('label' => 'Member Since', 'format' => 'm/d/Y'),
                null, array('required' => false, 'attr' => array('class' => 'datepicker')))
            ->add('secondary', null, array('label' => 'Secondary Member'))
            ->add('activenow', null, array('label' => 'Active'))
            ->add('locked')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('fullname', null, array('label' => 'Full Name'))
            ->add('membersince', 'date', array('label' => 'Member Since', 'format' => 'm/d/Y'))
            ->add('emailCanonical', null, array('label' => 'Login Email'))
            ->add('activenow', null, array('label' => 'Active Member'))
            ->add('secondary', null, array('label' => 'Secondary'))
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
