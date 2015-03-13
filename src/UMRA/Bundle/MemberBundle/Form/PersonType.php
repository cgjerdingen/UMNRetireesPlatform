<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use UMRA\Bundle\MemberBundle\Form\EventListener\IndeterminateDateSubscriber;

class PersonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                    'required' => false,
                    'empty_value' => array('year' => 'Year', 'month' => '', 'day' => '')
                ))
            ->add('ustartDayIndeterminate', 'hidden')
            ->add('ustartMonthIndeterminate', 'hidden')
            ->add('uretiredate', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'University Retire Date',
                    'required' => false,
                    'empty_value' => array('year' => 'Year', 'month' => '', 'day' => '')
                ))
            ->add('uretireDayIndeterminate', 'hidden')
            ->add('uretireMonthIndeterminate', 'hidden')
            ->add('deceasedate', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'Deceased Date',
                    'required' => false
                ))
            ->add('spouse', 'checkbox', array(
                    'label' => 'Spouse/Secondary Member',
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
                    'expanded' => true,
                    'required' => false
                ))
            ->add('weburl', 'url', array(
                    'label' => 'Personal Website',
                    'required' => false,
                    'attr' => array('placeholder' => 'e.g. http://umn.edu/~test001/')
                ))

            ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'required' => false,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Confirm Password')
                ))
            ->addEventSubscriber(new IndeterminateDateSubscriber())
            ->addEventListener(FormEvents::PRE_BIND, function (FormEvent $event) {
                $person = $event->getData();

                if (empty($person['plainPassword'])) {
                    unset($person['plainPassword']);
                }

                $event->setData($person);
            })
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UMRA\Bundle\MemberBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umra_bundle_memberbundle_person';
    }
}
