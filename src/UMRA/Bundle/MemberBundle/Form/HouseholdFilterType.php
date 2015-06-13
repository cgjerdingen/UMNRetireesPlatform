<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

class HouseholdFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('persons', 'filter_collection_adapter', array(
            'required'   => false,
            'type'       => new MemberFilterType(),
            'add_shared' => function (FilterBuilderExecuterInterface $qbe)  {
                $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                    // add the join clause to the doctrine query builder
                    // the where clause for the label and color fields will be added automatically with the right alias later by the Lexik\Filter\QueryBuilderUpdater
                    $filterBuilder->leftJoin($alias . '.persons', $joinAlias);
                };

                // then use the query builder executor to define the join, the join's alias and things to do on the doctrine query builder.
                $qbe->addOnce($qbe->getAlias().'.persons', 'person', $closure);
            },
        ));
        $builder->add('residences', 'filter_collection_adapter', array(
            'required'   => false,
            'type'       => new ResidenceFilterType(),
            'add_shared' => function (FilterBuilderExecuterInterface $qbe) {
                $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                    $filterBuilder->leftJoin($alias.'.residences', $joinAlias);
                };

                $qbe->addOnce($qbe->getAlias().'.residences', 'residence', $closure);
            },
        ));
    }

    public function getName()
    {
        return 'household_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
