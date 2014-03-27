<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
                    'label' => 'UMRA Member Since'
                ))
            ->add('utopunit', 'text', array(
                    'label' => 'University Unit'
                ))
            ->add('udeptequiv', 'text', array(
                    'label' => 'University Department'
                ))
            ->add('uempltype', 'text', array(
                    'label' => 'Employment Type'
                ))
            ->add('utitle', 'text', array(
                    'label' => 'Title'
                ))
            ->add('ustartdate', 'date', array(
                    'label' => 'University Start Date'
                ))
            ->add('uretiredate', 'date', array(
                    'label' => 'University Retire Date'
                ))
            ->add('joindate', 'date', array(
                    'label' => 'Join Date'
                ))
            ->add('deceasedate', 'date', array(
                    'label' => 'Deceased Date'
                ))
            ->add('activenow', 'checkbox', array(
                    'label' => 'Active',
                    'required' => false
                ))
            ->add('postalnews')
            ->add('weburl', 'url')
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
