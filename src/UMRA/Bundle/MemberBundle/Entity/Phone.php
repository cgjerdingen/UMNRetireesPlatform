<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone
 *
 * @ORM\Table(name="phone", indexes={@ORM\Index(name="PersonID", columns={"PersonID"}), @ORM\Index(name="ResID", columns={"ResID"})})
 * @ORM\Entity
 */
class Phone
{
    /**
     * @var string
     *
     * @ORM\Column(name="Phnumber", type="string", length=20, nullable=false)
     */
    private $phnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="Phtype", type="string", length=20, nullable=false)
     */
    private $phtype;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Residence
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Residence")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ResID", referencedColumnName="id")
     * })
     */
    private $resid;

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
     * Set phnumber
     *
     * @param string $phnumber
     * @return Phone
     */
    public function setPhnumber($phnumber)
    {
        $this->phnumber = $phnumber;

        return $this;
    }

    /**
     * Get phnumber
     *
     * @return string 
     */
    public function getPhnumber()
    {
        return $this->phnumber;
    }

    /**
     * Set phtype
     *
     * @param string $phtype
     * @return Phone
     */
    public function setPhtype($phtype)
    {
        $this->phtype = $phtype;

        return $this;
    }

    /**
     * Get phtype
     *
     * @return string 
     */
    public function getPhtype()
    {
        return $this->phtype;
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
     * Set resid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Residence $resid
     * @return Phone
     */
    public function setResid(\UMRA\Bundle\MemberBundle\Entity\Residence $resid = null)
    {
        $this->resid = $resid;

        return $this;
    }

    /**
     * Get resid
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Residence 
     */
    public function getResid()
    {
        return $this->resid;
    }

    /**
     * Set personid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $personid
     * @return Phone
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
