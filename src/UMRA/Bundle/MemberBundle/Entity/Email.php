<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\Choice(choices = {"primary", "secondary"}, message = "Must be primary or secondary")
     * @ORM\Column(name="PriSec", type="string", length=10, nullable=false)
     */
    private $prisec;

    /**
     * @var string
     *
     * @Assert\Email()
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
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person", inversedBy="emails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PersonID", referencedColumnName="id")
     * })
     */
    private $person;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Household
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Household")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="HouseholdID", referencedColumnName="id")
     * })
     */
    private $household;



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
     * Set person
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $person
     * @return Email
     */
    public function setPerson(\UMRA\Bundle\MemberBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set household
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Household $household
     * @return Email
     */
    public function setHousehold(\UMRA\Bundle\MemberBundle\Entity\Household $household = null)
    {
        $this->household = $household;

        return $this;
    }

    /**
     * Get household
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Household
     */
    public function getHousehold()
    {
        return $this->household;
    }
}
