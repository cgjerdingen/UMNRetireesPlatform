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
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Residence", inversedBy="phones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ResID", referencedColumnName="id")
     * })
     */
    private $residence;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person", inversedBy="phones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PersonID", referencedColumnName="id")
     * })
     */
    private $person;



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
     * Set residence
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Residence $residence
     * @return Phone
     */
    public function setResidence(\UMRA\Bundle\MemberBundle\Entity\Residence $residence = null)
    {
        $this->residence = $residence;

        return $this;
    }

    /**
     * Get residence
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Residence
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
     * Set person
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $person
     * @return Phone
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
