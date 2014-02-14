<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="Lastname", type="string", length=20, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="Firstname", type="string", length=20, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="Postalname", type="string", length=50, nullable=true)
     */
    private $postalname;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
