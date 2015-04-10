<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Household
 *
 * @ORM\Table(name="household")
 * @ORM\Entity
 */
class Household
{
    /**
     * @var string
     *
     * @ORM\Column(name="Lastname", type="string", length=30, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="Firstname", type="string", length=30, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="Postalname", type="string", length=50, nullable=true)
     */
    private $postalname;

    /**
     * @var Residence
     *
     * @ORM\OneToMany(targetEntity="Residence", mappedBy="household", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $residences;

    /**
     * @var Person
     *
     * @ORM\OneToMany(targetEntity="Person", mappedBy="household", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $persons;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function __construct() {
        $this->persons = new ArrayCollection();
        $this->residences = new ArrayCollection();
    }

    public function __toString() {
        return sprintf("Household of %s %s [%s] (ID: %d)", $this->firstname, $this->lastname, $this->postalname, $this->id);
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Household
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Household
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set postalname
     *
     * @param string $postalname
     * @return Household
     */
    public function setPostalname($postalname)
    {
        $this->postalname = $postalname;

        return $this;
    }

    /**
     * Get postalname
     *
     * @return string
     */
    public function getPostalname()
    {
        return $this->postalname;
    }

    /**
     * Add residence
     *
     * @param Residence $residence
     * @return Residence
     */
    public function addResidence(Residence $residence)
    {
        $this->residences[] = $residences;

        return $this;
    }

    /**
     * Remove residence
     *
     * @param Residence $residences
     */
    public function removeResidence(Residence $residence)
    {
        $this->residences->removeElement($residence);
    }

    /**
     * Get residences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResidences()
    {
        return $this->residences;
    }

    /**
     * Add person
     *
     * @param Person $person
     * @return Residence
     */
    public function addPerson(Person $person)
    {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove person
     *
     * @param Person $persons
     */
    public function removePerson(Person $person)
    {
        $this->persons->removeElement($person);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
