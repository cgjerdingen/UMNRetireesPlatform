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
            ->add('uempltype', 'text', array(
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
            ->add('postalnews')
            ->add('weburl', 'url', array(
                    'required' => false,
                    'attr' => array('placeholder' => 'e.g. http://umn.edu/~test001/')
                ))
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
