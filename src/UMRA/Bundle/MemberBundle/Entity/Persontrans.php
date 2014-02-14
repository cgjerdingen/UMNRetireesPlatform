<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Persontrans
 *
 * @ORM\Table(name="persontrans", indexes={@ORM\Index(name="PersonID", columns={"PersonID"}), @ORM\Index(name="TransID", columns={"TransID"})})
 * @ORM\Entity
 */
class Persontrans
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
     * @var \UMRA\Bundle\MemberBundle\Entity\Trans
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Trans")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="TransID", referencedColumnName="id")
     * })
     */
    private $transid;

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
     * Set transid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Trans $transid
     * @return Persontrans
     */
    public function setTransid(\UMRA\Bundle\MemberBundle\Entity\Trans $transid = null)
    {
        $this->transid = $transid;

        return $this;
    }

    /**
     * Get transid
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Trans 
     */
    public function getTransid()
    {
        return $this->transid;
    }

    /**
     * Set personid
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $personid
     * @return Persontrans
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
