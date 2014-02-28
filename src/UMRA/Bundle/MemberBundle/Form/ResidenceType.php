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
            ->add('primary')
            ->add('address1')
            ->add('address2')
            ->add('address3')
            ->add('city')
            ->add('state')
            ->add('zip')
            ->add('legdistrict')
            ->add('country')
            ->add('since')
            ->add('forseason')
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
