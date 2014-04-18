<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ResidenceType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('primary', 'checkbox', array('required' => false))
            ->add('address1', 'text', array(
                'label' => 'Address',
                'attr' => array('placeholder' => 'e.g. 123 Main Street')
                ))
            ->add('address2', 'text', array(
                'label' => 'Address 2',
                'label_attr' => array('class' => 'sr-only'),
                'required' => false,
                'attr' => array('placeholder' => 'e.g. Suite 3B')
                ))
            ->add('address3', 'text', array(
                'label' => 'Address 3',
                'label_attr' => array('class' => 'sr-only'),
                'required' => false,
                'attr' => array('placeholder' => 'e.g. c/o Steven Exampleton')
                ))
            ->add('city')
            ->add('state')
            ->add('zip', 'text', array(
                'label' => 'Zip/Postal Code',
                'attr' => array('placeholder' => 'e.g. 55455')
                ))
            ->add('legdistrict', 'text', array('label' => 'Legislative District'))
            ->add('country', 'country', array(
                'preferred_choices' => array('US')
                ))
            ->add('since', 'date', array(
                    'years' => range(1910, date('Y')),
                    'label' => 'Since',
                    'required' => false
                ))
            ->add('forseason', 'text', array(
                'label' => 'Season(s)',
                'required' => false,
                'attr' => array('placeholder' => 'e.g. April through August')
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UMRA\Bundle\MemberBundle\Entity\Residence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umra_bundle_memberbundle_residence';
    }
}
