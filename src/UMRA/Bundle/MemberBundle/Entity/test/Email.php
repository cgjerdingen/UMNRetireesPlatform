<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Email
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Email
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="HouseholdID", type="integer")
     */
    private $householdID;

    /**
     * @var integer
     *
     * @ORM\Column(name="PersonID", type="integer")
     */
    private $personID;

    /**
     * @var string
     *
     * @ORM\Column(name="PriSec", type="string", length=10)
     */
    private $priSec;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=20)
     */
    private $email;


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
     * Set householdID
     *
     * @param integer $householdID
     * @return Email
     */
    public function setHouseholdID($householdID)
    {
        $this->householdID = $householdID;

        return $this;
    }

    /**
     * Get householdID
     *
     * @return integer 
     */
    public function getHouseholdID()
    {
        return $this->householdID;
    }

    /**
     * Set personID
     *
     * @param integer $personID
     * @return Email
     */
    public function setPersonID($personID)
    {
        $this->personID = $personID;

        return $this;
    }

    /**
     * Get personID
     *
     * @return integer 
     */
    public function getPersonID()
    {
        return $this->personID;
    }

    /**
     * Set priSec
     *
     * @param string $priSec
     * @return Email
     */
    public function setPriSec($priSec)
    {
        $this->priSec = $priSec;

        return $this;
    }

    /**
     * Get priSec
     *
     * @return string 
     */
    public function getPriSec()
    {
        return $this->priSec;
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
}
