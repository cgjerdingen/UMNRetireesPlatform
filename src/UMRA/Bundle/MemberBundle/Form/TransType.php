<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trandate', null, array('label' => 'Transaction Date'))
            ->add('trantype', 'choice', array(
                    'label' => 'Transaction Type',
                    'choices' => array(
                        'MEMBERSHIP_NEW' => 'New Membership',
                        'MEMBERSHIP_RENEW' => 'Membership Renewal',
                        'LUNCHEON_FEE' => 'Luncheon Fee',
                        'PARKING_PASS' => 'Parking Pass',
                        'OTHER' => 'Other'
                    ),
                ))
            ->add('amount')
            ->add('pmtmethod', 'choice', array(
                    'label' => 'Payment Method',
                    'choices' => array('CREDIT_CARD' => 'Credit Card', 'CHECK' => 'Check', 'OTHER' => 'Other'),
                ))
            ->add('servicechg', null, array('label' => 'Service Charge'))
            ->add('person', 'entity', array(
                'class' => 'UMRAMemberBundle:Person',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.fullname', 'ASC');
                }
            ))
            ->add('status', 'choice', array(
                    'label' => 'Transaction Type',
                    'choices' => array('AWAITING_PROCESS' => 'Awaiting Process', 'PROCESSING' => 'Processing', 'PROCESSED' => 'Processed'),
                ))
            ->add('reconciledDate', null, array('label' => 'Reconciled Date'))
            ->add('notes', 'textarea', array(
                'required' => false
            ))
            ->add('luncheon', 'entity', array(
                'class' => 'UMRAMemberBundle:Luncheon',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->orderBy('l.luncheonDate', 'DESC');
                },
                'required' => false
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UMRA\Bundle\MemberBundle\Entity\Trans'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umra_bundle_memberbundle_trans';
    }
}
