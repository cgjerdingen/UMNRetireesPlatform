<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table(name="email", indexes={@ORM\Index(name="HouseholdID", columns={"HouseholdID"}), @ORM\Index(name="PersonID", columns={"PersonID"})})
 * @ORM\Entity
 */
class Email
{
    /**
     * @var string
     *
     * @ORM\Column(name="PriSec", type="string", length=10, nullable=false)
     */
    private $prisec;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=20, nullable=false)
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PersonID", referencedColumnName="id")
     * })
     */
    private $personid;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Household
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Household")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="HouseholdID", referencedColumnName="id")
     * })
     */
    private $householdid;



    /**
     * Set prisec
     *
     * @param string $prisec
     * @return Email
     */
    public function setPrisec($prisec)
    {
        $this->prisec = $prisec;

        return $this;
    }

    /**
     * Get prisec
     *
     * @return string 
     */
    public function getPrisec()
    {
        return $this->prisec;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
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

    /**
     * Set personid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $personid
     * @return Email
     */
    public function setPersonid(\UMRA\Bundle\MemberBundle\Entity\Person $personid = null)
    {
        $this->personid = $personid;

        return $this;
    }

    /**
     * Get personid
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Person 
     */
    public function getPersonid()
    {
        return $this->personid;
    }

    /**
     * Set householdid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Household $householdid
     * @return Email
     */
    public function setHouseholdid(\UMRA\Bundle\MemberBundle\Entity\Household $householdid = null)
    {
        $this->householdid = $householdid;

        return $this;
    }

    /**
     * Get householdid
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Household 
     */
    public function getHouseholdid()
    {
        return $this->householdid;
    }
}
