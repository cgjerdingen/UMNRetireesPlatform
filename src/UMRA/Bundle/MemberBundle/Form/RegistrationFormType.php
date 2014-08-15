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
					'prototype' => true,
				))
				->add('residences', 'collection', array(
					'type' => new ResidenceType(),
					'allow_add' => true
				))
				->add('primaryEmail', new EmailType())
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
		return 'umra_member_registration';
	}
}