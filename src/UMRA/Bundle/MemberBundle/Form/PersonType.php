<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
            ->add('x500', 'text', array(
                    'label' => 'UMN Internet ID (X.500 ID) / UMRA Username',
                    'required' => false,
                    'attr' => array('placeholder' => 'e.g. goldy001. If none, leave blank.')
                ))
            ->add('nickname', 'text', array(
                    'label' => 'Nickname'
                ))
            ->add('fullname', 'text', array(
                    'label' => 'Full Name'
                ))
            ->add('postalname', 'text', array(
                    'label' => 'Postal Name'
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
            ->add('joindate', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'Join Date',
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

            ->addEventListener(FormEvents::PRE_BIND, function (FormEvent $event) {
                $person = $event->getData();

                if (empty($person["x500"])) {
                    /* If the user doesn't have an X.500, we'll create a username for them.
                     * Format: umra_[first 5 chars of last name][uniqid() result]
                     */
                    $dummyId = "umra_" . substr(strtolower($person["lastname"]), 0, 5) . substr(uniqid(), 5, 4);

                    $person["x500"] = $dummyId;
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
