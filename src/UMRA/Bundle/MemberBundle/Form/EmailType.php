<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prisec', 'choice', array(
                'label' => 'Type',
                'choices' => array('primary' => 'Primary', 'secondary' => 'Secondary'),
                'expanded' => true
                ))
            ->add('email', 'email')
            ->add('person', 'entity', array(
            'class' => 'UMRAMemberBundle:Person', 'property' => 'Fullname',))
            ->add('household', 'entity', array(
            'class' => 'UMRAMemberBundle:Household', 'property' => 'Postalname',))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UMRA\Bundle\MemberBundle\Entity\Email'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umra_bundle_memberbundle_email';
    }
}
