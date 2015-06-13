<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

class MemberFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', 'filter_text');
        $builder->add('lastname', 'filter_text');
        $builder->add('activenow', 'filter_boolean');
        $builder->add('newsPref', 'filter_choice', array(
            'choices' => array(
                'postal' => 'Postal Mail',
                'email' => 'Email',
                'both' => 'Both'
            ),
            'label' => 'Newsletter Preference'
        ));
        $builder->add('emails', 'filter_collection_adapter', array(
            'type'       => new EmailFilterType(),
            'add_shared' => function (FilterBuilderExecuterInterface $qbe) {
                $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                    $filterBuilder->leftJoin($alias . '.emails', $joinAlias);
                };

                $qbe->addOnce($qbe->getAlias().'.emails', 'email', $closure);
            },
        ));
        $builder->add('transactions', 'filter_collection_adapter', array(
            'type'       => new TransFilterType(),
            'add_shared' => function (FilterBuilderExecuterInterface $qbe)  {
                $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                    $filterBuilder->leftJoin($alias . '.transactions', $joinAlias);
                };

                $qbe->addOnce($qbe->getAlias().'.transactions', 'transaction', $closure);
            },
        ));
    }

    public function getName()
    {
        return 'member_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
