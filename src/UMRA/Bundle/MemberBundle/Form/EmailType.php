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
            ->add('type', 'choice', array(
                'label' => 'Type',
                'choices' => array('personal' => 'Personal', 'work' => 'Work', 'other' => 'Other'),
                'expanded' => true
                ))
            ->add('email', 'email')
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
