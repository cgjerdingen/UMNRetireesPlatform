<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Residence
 *
 * @ORM\Table(name="residence", indexes={@ORM\Index(name="HouseholdID", columns={"HouseholdID"})})
 * @ORM\Entity
 */
class Residence
{
    /**
     * @var boolean
     *
     * @ORM\Column(name="PriSec", type="boolean", nullable=false)
     */
    private $primary;

    /**
     * @var string
     *
     * @ORM\Column(name="Address1", type="string", length=35, nullable=true)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="Address2", type="string", length=35, nullable=true)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="Address3", type="string", length=35, nullable=true)
     */
    private $address3;

    /**
     * @var string
     *
     * @ORM\Column(name="City", type="string", length=35, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="State", type="string", length=35, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="Zip", type="string", length=6, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="Legdistrict", type="string", length=35, nullable=true)
     */
    private $legdistrict;

    /**
     * @var string
     *
     * @ORM\Column(name="Country", type="string", length=20, nullable=true)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Since", type="date", nullable=true)
     */
    private $since;

    /**
     * @var string
     *
     * @ORM\Column(name="Forseason", type="string", length=35, nullable=true)
     */
    private $forseason;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Household
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Household", inversedBy="residences")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="HouseholdID", referencedColumnName="id")
     * })
     */
    private $household;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Phone
     *
     * @ORM\OneToMany(targetEntity="UMRA\Bundle\MemberBundle\Entity\Phone", mappedBy="residence")
     */
    private $phones;

    public function __toString()
    {
        $string = "$this->address1" . "\n";
        if (!empty($this->address2)) {
            $string .= $this->address2 . "\n";
        }
        if (!empty($this->address3)) {
            $string .= $this->address3 . "\n";
        }
        $string .= $this->city;
        if (!empty($this->state)) {
            $string .= ", $this->state";
        }
        $string .= $this->zip . "\n" . $this->country;
        return $string;
    }

    /**
     * Set prisec
     *
     * @param boolean $primary
     * @return Residence
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;

        return $this;
    }

    /**
     * Is primary?
     *
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Residence
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Residence
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set address3
     *
     * @param string $address3
     * @return Residence
     */
    public function setAddress3($address3)
    {
        $this->address3 = $address3;

        return $this;
    }

    /**
     * Get address3
     *
     * @return string
     */
    public function getAddress3()
    {
        return $this->address3;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Residence
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Residence
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Residence
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set legdistrict
     *
     * @param string $legdistrict
     * @return Residence
     */
    public function setLegdistrict($legdistrict)
    {
        $this->legdistrict = $legdistrict;

        return $this;
    }

    /**
     * Get legdistrict
     *
     * @return string
     */
    public function getLegdistrict()
    {
        return $this->legdistrict;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Residence
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set since
     *
     * @param \DateTime $since
     * @return Residence
     */
    public function setSince($since)
    {
        $this->since = $since;

        return $this;
    }

    /**
     * Get since
     *
     * @return \DateTime
     */
    public function getSince()
    {
        return $this->since;
    }

    /**
     * Set forseason
     *
     * @param string $forseason
     * @return Residence
     */
    public function setForseason($forseason)
    {
        $this->forseason = $forseason;

        return $this;
    }

    /**
     * Get forseason
     *
     * @return string
     */
    public function getForseason()
    {
        return $this->forseason;
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
     * Set household
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Household $household
     * @return Residence
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

    /**
     * Add phone
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Phone $email
     * @return Residence
     */
    public function addPhone(\UMRA\Bundle\MemberBundle\Entity\Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Phone $phone
     */
    public function removePhone(\UMRA\Bundle\MemberBundle\Entity\Phone $phone)
    {
        $this->phones->removeElement($phone);
    }

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhones()
    {
        return $this->phones;
    }
}
