<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Email
 *
 * @ORM\Table(name="email",
 *            indexes={@ORM\Index(name="HouseholdID", columns={"HouseholdID"}),
 *                     @ORM\Index(name="PersonID", columns={"PersonID"})},
 *            uniqueConstraints={@ORM\UniqueConstraint(name="OnePreferredPerUser", columns={"preferred", "PersonID"})}
 * )
 * @UniqueEntity(fields={"email"}, message="The specified email already exists.")
 * @UniqueEntity(fields={"preferred", "person"}, message="Cannot have more than one preferred email")
 * @ORM\Entity
 */
class Email
{
    /**
     * @var string
     *
     * @Assert\Choice(choices = {"personal", "shared", "work", "other"}, message = "Must be personal, shared, work, or other")
     * @ORM\Column(name="Type", type="string", length=10, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @Assert\Email()
     * @ORM\Column(name="Email", type="string", length=60, nullable=false, unique=True)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Preferred", type="boolean", nullable=True)
     */
    private $preferred;

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

    public function __toString()
    {
        return $this->email . " - " . $this->type;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Email
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * Set preferred
     *
     * @param boolean $preferred
     * @return Person
     */
    public function setPreferred($preferred)
    {
        $this->preferred = $preferred;

        return $this;
    }

    /**
     * Get preferred
     *
     * @return boolean
     */
    public function isPreferred()
    {
        return $this->preferred;
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
