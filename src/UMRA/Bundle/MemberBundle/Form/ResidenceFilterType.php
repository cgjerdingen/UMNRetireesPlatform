<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class ResidenceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('address1', 'filter_text', array(
            'label' => 'Address 1',
            'condition_pattern' => FilterOperands::STRING_BOTH
        ));

        $builder->add('city', 'filter_text', array(
            'condition_pattern' => FilterOperands::STRING_BOTH
        ));

        $builder->add('state', 'filter_text', array(
            'condition_pattern' => FilterOperands::STRING_BOTH
        ));

        $builder->add('zip', 'filter_text', array(
            'condition_pattern' => FilterOperands::STRING_BOTH
        ));
    }

    public function getName()
    {
        return 'residence_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
