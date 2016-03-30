<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

class TransFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trandate', 'filter_date_range', array(
                'label' => 'Transaction Date'
            ))
            ->add('trantype', 'filter_choice', array(
                'label' => 'Transaction Type',
                'choices' => array(
                    'MEMBERSHIP_NEW' => 'New Membership',
                    'MEMBERSHIP_RENEW' => 'Membership Renewal',
                    'LUNCHEON_FEE' => 'Luncheon Fee',
                    'PARKING_PASS' => 'Parking Pass',
                    'OTHER' => 'Other'
                ),
            ))
            ->add('status', 'filter_choice', array(
                'label' => 'Transaction Status',
                'choices' => array('AWAITING_PROCESS' => 'Awaiting Process', 'PROCESSING' => 'Processing', 'PROCESSED' => 'Processed'),
            ))
            ->add('person', new TransMemberFilterType(), array(
                'required' => false,
                'add_shared' => function (FilterBuilderExecuterInterface $qbe)  {
                    $closure = function (QueryBuilder $filterBuilder, $alias, $joinAlias, Expr $expr) {
                        // add the join clause to the doctrine query builder
                        // the where clause for the label and color fields will be added automatically with the right alias later by the Lexik\Filter\QueryBuilderUpdater
                        $filterBuilder->leftJoin($alias . '.person', $joinAlias);
                    };

                    // then use the query builder executor to define the join, the join's alias and things to do on the doctrine query builder.
                    $qbe->addOnce($qbe->getAlias().'.person', 'p', $closure);
                },
            ));
        ;
    }

    public function getName()
    {
        return 'trans_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
