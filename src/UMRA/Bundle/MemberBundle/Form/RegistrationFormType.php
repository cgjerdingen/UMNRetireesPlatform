<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('household', new HouseholdType())
				->add('members', 'collection', array(
					'type' => new RegistrationPersonType(),
					'allow_add' => true,
					'allow_delete' => true,
					'by_reference' => false
				))
				->add('residences', 'collection', array(
					'type' => new ResidenceType(),
					'allow_add' => true,
					'allow_delete' => true,
					'by_reference' => false
				))
				->add('membershipType', 'choice', array(
					'choices' => array(
						'10' => 'Single ($10)',
						'15' => 'Couple ($15)'
					),
					'expanded' => true
				))
				->add('luncheonPreorder', 'choice', array(
					'choices' => array(
						'single' => 'Single ($112)',
						'couple' => 'Couple ($224)',
						'none' => 'Do not pre-purchase'
					),
					'expanded' => true
				))
				->add('parkingCoupon', 'choice', array(
					'choices' => array(
						'0' => '0',
						'1' => '1',
						'3' => '3',
						'6' => '6',
						'9' => '9'
					),
					'expanded' => true
				))
				->add('payCreditCard', 'submit', array(
					'label' => 'Pay by Credit Card',
					'attr' => array('class' => 'btn btn-primary')
				))
				->add('payCheck', 'submit', array(
					'label' => 'Print & Pay by Check',
					'attr' => array('class' => 'btn btn-link')
				))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'cascade_validation' => true
	    ));
	}

	public function getName()
	{
		return 'register';
	}
}
