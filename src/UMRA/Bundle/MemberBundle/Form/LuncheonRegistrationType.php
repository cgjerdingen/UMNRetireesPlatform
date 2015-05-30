<?php

namespace UMRA\Bundle\MemberBundle\Form;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


class LuncheonRegistrationType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $household = $options["household"];

        $builder
            ->add('members', 'entity', array(
                'label'   => 'Members',
                'class'   => 'UMRA\Bundle\MemberBundle\Entity\Person',
                'choices' => $household->getPersons(),
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ))
            ->add('luncheon', 'entity', array(
                'label'         => 'Luncheon',
                'class'         => 'UMRA\Bundle\MemberBundle\Entity\Luncheon',
                'query_builder' => function (EntityRepository $er) {
                    return $er
                        ->createQueryBuilder('l')
                        ->where('l.registrationOpen = 1')
                        ->andWhere('l.luncheonDate > :now')
                        ->setParameter('now', new \DateTime("now"))
                        ->orderBy('l.luncheonDate', 'ASC');
                }
            ))
            ->add('payCreditCard', 'submit', array(
                'label' => 'Pay by Credit Card',
                'attr' => array('class' => 'btn btn-primary')
            ))
            ->add('payCheck', 'submit', array(
                'label' => 'Pay by Check',
                'attr' => array('class' => 'btn btn-default')
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'household',
        ));

        $resolver->setAllowedTypes(array(
            'household' => 'UMRA\Bundle\MemberBundle\Entity\household',
        ));

        $resolver->setDefaults(array(
            'constraints' => array(
                new Callback(array(
                    'methods' => array(
                        array($this,'validate'))
                    )
                )
            )
        ));
    }

    public function validate($data, ExecutionContextInterface $context)
    {
        $members = $data["members"];
        $luncheon = $data["luncheon"];

        if (count($members) < 1) {
            $context->addViolation('You must select some members.');
        }

        $checkTransactionForLuncheon = function($key, $element) use ($luncheon) {
            $elementLuncheon = $element->getLuncheon();

            return $elementLuncheon === null
                    ? false
                    : $elementLuncheon->getId() === $luncheon->getId();
        };

        foreach($members as $member) {
            if ($member->getTransactions()->exists($checkTransactionForLuncheon)) {
                $context->addViolation($member . ' has already registered for the selected luncheon.');
            }
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lunch_reg';
    }
}
