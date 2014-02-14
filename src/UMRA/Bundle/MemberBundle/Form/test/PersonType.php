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
            ->add('lastName')
            ->add('firstName')
            ->add('fullName')
            ->add('mailName')
            ->add('labelName')
            ->add('sSOFullName')
            ->add('memberSince')
            ->add('utopUnit')
            ->add('uDeptEquiv')
            ->add('uEmplType')
            ->add('uTitle')
            ->add('uStartDate')
            ->add('uRetireDate')
            ->add('joinDate')
            ->add('deceasedDate')
            ->add('mailNewsLetter')
            ->add('webPage')
            ->add('comment')
            ->add('partnerPersonID')
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
