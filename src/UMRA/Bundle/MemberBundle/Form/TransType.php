<?php

namespace UMRA\Bundle\MemberBundle\Form;

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
                'choices' => array('MEMBERSHIP_NEW' => 'New Membership', 'MEMBERSHIP_RENEW' => 'Membership Renewal', 'LUNCHEON_FEE' => 'Luncheon Fee', 'OTHER' => 'Other'),
                ))
            ->add('amount')
            ->add('pmtmethod', 'choice', array(
                'label' => 'Payment Method',
                'choices' => array('CREDIT_CARD' => 'Credit Card', 'CHECK' => 'Check', 'OTHER' => 'Other'),
                ))
            ->add('servicechg', null, array('label' => 'Service Charge'))
            ->add('doneby', null, array('label' => 'Done By'))
            ->add('notes')
            ->add('person')
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
