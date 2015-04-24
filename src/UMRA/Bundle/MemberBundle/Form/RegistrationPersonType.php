<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class RegistrationPersonType extends PersonType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('emailCanonical', 'email', array(
                'label' => 'Email',
                'required' => false
            ));
        $builder->remove('deceasedate');
        $builder->remove('activenow');
        $builder->remove('plainPassword');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'person';
    }
}