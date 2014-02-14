<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personrole
 *
 * @ORM\Table(name="personrole", indexes={@ORM\Index(name="PersonID", columns={"PersonID"}), @ORM\Index(name="RoleID", columns={"RoleID"})})
 * @ORM\Entity
 */
class Personrole
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="RoleID", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PersonID", referencedColumnName="id")
     * })
     */
    private $person;



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
     * Set role
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Role $role
     * @return Personrole
     */
    public function setRole(\UMRA\Bundle\MemberBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set person
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $person
     * @return Personrole
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
}
