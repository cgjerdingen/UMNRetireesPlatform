<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trans
 *
 * @ORM\Table(name="trans")
 * @ORM\Entity
 */
class Trans
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Trandate", type="date", nullable=false)
     */
    private $trandate;

    /**
     * @var string
     *
     * @ORM\Column(name="Trantype", type="string", length=20, nullable=false)
     */
    private $trantype;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="Pmtmethod", type="string", length=20, nullable=false)
     */
    private $pmtmethod;

    /**
     * @var string
     *
     * @ORM\Column(name="Servicechg", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $servicechg;

    /**
     * @var string
     *
     * @ORM\Column(name="Doneby", type="string", length=20, nullable=false)
     */
    private $doneby;

    /**
     * @var string
     *
     * @ORM\Column(name="Notes", type="string", length=20, nullable=true)
     */
    private $notes;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set trandate
     *
     * @param \DateTime $trandate
     * @return Trans
     */
    public function setTrandate($trandate)
    {
        $this->trandate = $trandate;

        return $this;
    }

    /**
     * Get trandate
     *
     * @return \DateTime 
     */
    public function getTrandate()
    {
        return $this->trandate;
    }

    /**
     * Set trantype
     *
     * @param string $trantype
     * @return Trans
     */
    public function setTrantype($trantype)
    {
        $this->trantype = $trantype;

        return $this;
    }

    /**
     * Get trantype
     *
     * @return string 
     */
    public function getTrantype()
    {
        return $this->trantype;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return Trans
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set pmtmethod
     *
     * @param string $pmtmethod
     * @return Trans
     */
    public function setPmtmethod($pmtmethod)
    {
        $this->pmtmethod = $pmtmethod;

        return $this;
    }

    /**
     * Get pmtmethod
     *
     * @return string 
     */
    public function getPmtmethod()
    {
        return $this->pmtmethod;
    }

    /**
     * Set servicechg
     *
     * @param string $servicechg
     * @return Trans
     */
    public function setServicechg($servicechg)
    {
        $this->servicechg = $servicechg;

        return $this;
    }

    /**
     * Get servicechg
     *
     * @return string 
     */
    public function getServicechg()
    {
        return $this->servicechg;
    }

    /**
     * Set doneby
     *
     * @param string $doneby
     * @return Trans
     */
    public function setDoneby($doneby)
    {
        $this->doneby = $doneby;

        return $this;
    }

    /**
     * Get doneby
     *
     * @return string 
     */
    public function getDoneby()
    {
        return $this->doneby;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Trans
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
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
