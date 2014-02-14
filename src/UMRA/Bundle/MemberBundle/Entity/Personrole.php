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
    private $roleid;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set roleid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Role $roleid
     * @return Personrole
     */
    public function setRoleid(\UMRA\Bundle\MemberBundle\Entity\Role $roleid = null)
    {
        $this->roleid = $roleid;

        return $this;
    }

    /**
     * Get roleid
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Role 
     */
    public function getRoleid()
    {
        return $this->roleid;
    }

    /**
     * Set personid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $personid
     * @return Personrole
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
}
