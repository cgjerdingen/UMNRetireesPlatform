<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('nickname')
            ->add('fullname')
            ->add('postalname')
            ->add('nametagname')
            ->add('membersince')
            ->add('utopunit')
            ->add('udeptequiv')
            ->add('uempltype')
            ->add('utitle')
            ->add('ustartdate')
            ->add('uretiredate')
            ->add('joindate')
            ->add('deceasedate')
            ->add('activenow')
            ->add('postalnews')
            ->add('weburl')
            ->add('household', 'entity', array(
			'class' => 'UMRAMemberBundle:Household', 'property' => 'Postalname',))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UMRA\Bundle\MemberBundle\Entity\Person'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'umra_bundle_memberbundle_person';
    }
}
