<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

class MemberTransFilterType extends AbstractType
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
        ;
    }

    public function getName()
    {
        return 'member_trans_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
