<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class TransMemberFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'filter_text', array(
            'label' => 'First Name',
            'condition_pattern' => FilterOperands::STRING_BOTH,
            'attr' => array(
                'class' => 'form-control input-sm'
            )
        ));
        $builder->add('lastname', 'filter_text', array(
            'label' => 'Last Name',
            'condition_pattern' => FilterOperands::STRING_BOTH,
            'attr' => array(
                'class' => 'form-control input-sm'
            )
        ));
    }

    public function getName()
    {
        return 'trans_member_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
