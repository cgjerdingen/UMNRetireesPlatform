<?php

namespace UMRA\Bundle\MemberBundle\Form\Handler;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;

class HouseholdFormHandler
{
    private $em;

    public function __construct(ObjectManager $em, $form)
    {
        $this->em = $em;
        $this->form = $form;
    }

    public function processSave($entity, $originalMembers = array(), $originalResidences = array())
    {
        // Remove any members not PUT back.
        foreach ($originalMembers as $person) {
            if (false === $entity->getPersons()->contains($person)) {
                $entity->getPersons()->removeElement($person);
                $this->em->persist($entity);
                $this->em->remove($person);
            }
        }

        // Remove any residences not PUT back.
        foreach ($originalResidences as $res) {
            if (false === $entity->getResidences()->contains($res)) {
                $entity->getResidences()->removeElement($res);
                $this->em->persist($entity);
                $this->em->remove($res);
            }
        }

        // Set household relation on people.
        foreach($entity->getPersons() as $person) {
            $person->setHousehold($entity);
        }

        // Set household relation on residences.
        foreach($entity->getResidences() as $res) {
            $res->setHousehold($entity);
        }

        $primaryMember = !$entity->getPersons()->isEmpty()
            ? $entity->getPersons()->first()
            : null;

        if ($primaryMember) {
            if (empty($entity->getFirstname())) {
                $entity->setFirstname($primaryMember->getFirstname());
            }

            if (empty($entity->getLastname())) {
                $entity->setLastname($primaryMember->getLastname());
            }
        }

        $this->em->persist($entity);
        $this->em->flush();
    }
}
