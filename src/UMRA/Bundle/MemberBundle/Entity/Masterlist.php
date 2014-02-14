<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Masterlist
 *
 * @ORM\Table(name="masterlist")
 * @ORM\Entity
 */
class Masterlist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="CplSgl", type="integer", nullable=true)
     */
    private $cplsgl;

    /**
     * @var string
     *
     * @ORM\Column(name="spLast", type="string", length=50, nullable=true)
     */
    private $splast;

    /**
     * @var string
     *
     * @ORM\Column(name="spmember", type="string", length=50, nullable=true)
     */
    private $spmember;

    /**
     * @var string
     *
     * @ORM\Column(name="spnonmb", type="string", length=53, nullable=true)
     */
    private $spnonmb;

    /**
     * @var string
     *
     * @ORM\Column(name="labelname", type="string", length=68, nullable=true)
     */
    private $labelname;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=73, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=50, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="Zip", type="string", length=50, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="NewDistrict", type="string", length=50, nullable=true)
     */
    private $newdistrict;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone2", type="string", length=50, nullable=true)
     */
    private $telephone2;

    /**
     * @var string
     *
     * @ORM\Column(name="dept", type="string", length=113, nullable=true)
     */
    private $dept;

    /**
     * @var string
     *
     * @ORM\Column(name="Emptype", type="string", length=10, nullable=true)
     */
    private $emptype;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=61, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Secondemail", type="string", length=57, nullable=true)
     */
    private $secondemail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Datejoined", type="datetime", nullable=true)
     */
    private $datejoined;

    /**
     * @var string
     *
     * @ORM\Column(name="Newsletter", type="string", length=50, nullable=true)
     */
    private $newsletter;

    /**
     * @var string
     *
     * @ORM\Column(name="Parkingcoupons", type="string", length=50, nullable=true)
     */
    private $parkingcoupons;

    /**
     * @var integer
     *
     * @ORM\Column(name="Lunchprepay1314", type="integer", nullable=true)
     */
    private $lunchprepay1314;

    /**
     * @var integer
     *
     * @ORM\Column(name="Dues1314", type="integer", nullable=true)
     */
    private $dues1314;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DtRcvd1314", type="datetime", nullable=true)
     */
    private $dtrcvd1314;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Deposit1314", type="datetime", nullable=true)
     */
    private $deposit1314;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Sendcard1314", type="datetime", nullable=true)
     */
    private $sendcard1314;

    /**
     * @var string
     *
     * @ORM\Column(name="Comments1314", type="string", length=187, nullable=true)
     */
    private $comments1314;

    /**
     * @var string
     *
     * @ORM\Column(name="TwoCards", type="string", length=50, nullable=true)
     */
    private $twocards;

    /**
     * @var string
     *
     * @ORM\Column(name="Dues1112", type="string", length=50, nullable=true)
     */
    private $dues1112;

    /**
     * @var string
     *
     * @ORM\Column(name="Deposit1112", type="string", length=52, nullable=true)
     */
    private $deposit1112;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Sendcard1112", type="datetime", nullable=true)
     */
    private $sendcard1112;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DtRcvd1112", type="datetime", nullable=true)
     */
    private $dtrcvd1112;

    /**
     * @var string
     *
     * @ORM\Column(name="Comments1112", type="string", length=182, nullable=true)
     */
    private $comments1112;

    /**
     * @var integer
     *
     * @ORM\Column(name="UMRArole", type="integer", nullable=true)
     */
    private $umrarole;

    /**
     * @var integer
     *
     * @ORM\Column(name="Dues1213", type="integer", nullable=true)
     */
    private $dues1213;

    /**
     * @var integer
     *
     * @ORM\Column(name="Lunchprepay", type="integer", nullable=true)
     */
    private $lunchprepay;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Deposit1213", type="datetime", nullable=true)
     */
    private $deposit1213;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Sendcard1213", type="datetime", nullable=true)
     */
    private $sendcard1213;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DtRcvd1213", type="datetime", nullable=true)
     */
    private $dtrcvd1213;

    /**
     * @var string
     *
     * @ORM\Column(name="Comments1213", type="string", length=140, nullable=true)
     */
    private $comments1213;

    /**
     * @var string
     *
     * @ORM\Column(name="UseAltAddress", type="string", length=54, nullable=true)
     */
    private $usealtaddress;

    /**
     * @var string
     *
     * @ORM\Column(name="AltAddress", type="string", length=62, nullable=true)
     */
    private $altaddress;

    /**
     * @var string
     *
     * @ORM\Column(name="AltCity", type="string", length=50, nullable=true)
     */
    private $altcity;

    /**
     * @var string
     *
     * @ORM\Column(name="AltState", type="string", length=50, nullable=true)
     */
    private $altstate;

    /**
     * @var string
     *
     * @ORM\Column(name="AltZIP", type="string", length=50, nullable=true)
     */
    private $altzip;

    /**
     * @var string
     *
     * @ORM\Column(name="AltPhone", type="string", length=50, nullable=true)
     */
    private $altphone;

    /**
     * @var integer
     *
     * @ORM\Column(name="Yrjoin", type="integer", nullable=true)
     */
    private $yrjoin;

    /**
     * @var string
     *
     * @ORM\Column(name="first", type="string", length=52)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $first;

    /**
     * @var string
     *
     * @ORM\Column(name="Last", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $last;



    /**
     * Set cplsgl
     *
     * @param integer $cplsgl
     * @return Masterlist
     */
    public function setCplsgl($cplsgl)
    {
        $this->cplsgl = $cplsgl;

        return $this;
    }

    /**
     * Get cplsgl
     *
     * @return integer 
     */
    public function getCplsgl()
    {
        return $this->cplsgl;
    }

    /**
     * Set splast
     *
     * @param string $splast
     * @return Masterlist
     */
    public function setSplast($splast)
    {
        $this->splast = $splast;

        return $this;
    }

    /**
     * Get splast
     *
     * @return string 
     */
    public function getSplast()
    {
        return $this->splast;
    }

    /**
     * Set spmember
     *
     * @param string $spmember
     * @return Masterlist
     */
    public function setSpmember($spmember)
    {
        $this->spmember = $spmember;

        return $this;
    }

    /**
     * Get spmember
     *
     * @return string 
     */
    public function getSpmember()
    {
        return $this->spmember;
    }

    /**
     * Set spnonmb
     *
     * @param string $spnonmb
     * @return Masterlist
     */
    public function setSpnonmb($spnonmb)
    {
        $this->spnonmb = $spnonmb;

        return $this;
    }

    /**
     * Get spnonmb
     *
     * @return string 
     */
    public function getSpnonmb()
    {
        return $this->spnonmb;
    }

    /**
     * Set labelname
     *
     * @param string $labelname
     * @return Masterlist
     */
    public function setLabelname($labelname)
    {
        $this->labelname = $labelname;

        return $this;
    }

    /**
     * Get labelname
     *
     * @return string 
     */
    public function getLabelname()
    {
        return $this->labelname;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Masterlist
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Masterlist
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
     * @return Masterlist
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
     * @return Masterlist
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
     * Set newdistrict
     *
     * @param string $newdistrict
     * @return Masterlist
     */
    public function setNewdistrict($newdistrict)
    {
        $this->newdistrict = $newdistrict;

        return $this;
    }

    /**
     * Get newdistrict
     *
     * @return string 
     */
    public function getNewdistrict()
    {
        return $this->newdistrict;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Masterlist
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set telephone2
     *
     * @param string $telephone2
     * @return Masterlist
     */
    public function setTelephone2($telephone2)
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    /**
     * Get telephone2
     *
     * @return string 
     */
    public function getTelephone2()
    {
        return $this->telephone2;
    }

    /**
     * Set dept
     *
     * @param string $dept
     * @return Masterlist
     */
    public function setDept($dept)
    {
        $this->dept = $dept;

        return $this;
    }

    /**
     * Get dept
     *
     * @return string 
     */
    public function getDept()
    {
        return $this->dept;
    }

    /**
     * Set emptype
     *
     * @param string $emptype
     * @return Masterlist
     */
    public function setEmptype($emptype)
    {
        $this->emptype = $emptype;

        return $this;
    }

    /**
     * Get emptype
     *
     * @return string 
     */
    public function getEmptype()
    {
        return $this->emptype;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Masterlist
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
     * Set secondemail
     *
     * @param string $secondemail
     * @return Masterlist
     */
    public function setSecondemail($secondemail)
    {
        $this->secondemail = $secondemail;

        return $this;
    }

    /**
     * Get secondemail
     *
     * @return string 
     */
    public function getSecondemail()
    {
        return $this->secondemail;
    }

    /**
     * Set datejoined
     *
     * @param \DateTime $datejoined
     * @return Masterlist
     */
    public function setDatejoined($datejoined)
    {
        $this->datejoined = $datejoined;

        return $this;
    }

    /**
     * Get datejoined
     *
     * @return \DateTime 
     */
    public function getDatejoined()
    {
        return $this->datejoined;
    }

    /**
     * Set newsletter
     *
     * @param string $newsletter
     * @return Masterlist
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return string 
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set parkingcoupons
     *
     * @param string $parkingcoupons
     * @return Masterlist
     */
    public function setParkingcoupons($parkingcoupons)
    {
        $this->parkingcoupons = $parkingcoupons;

        return $this;
    }

    /**
     * Get parkingcoupons
     *
     * @return string 
     */
    public function getParkingcoupons()
    {
        return $this->parkingcoupons;
    }

    /**
     * Set lunchprepay1314
     *
     * @param integer $lunchprepay1314
     * @return Masterlist
     */
    public function setLunchprepay1314($lunchprepay1314)
    {
        $this->lunchprepay1314 = $lunchprepay1314;

        return $this;
    }

    /**
     * Get lunchprepay1314
     *
     * @return integer 
     */
    public function getLunchprepay1314()
    {
        return $this->lunchprepay1314;
    }

    /**
     * Set dues1314
     *
     * @param integer $dues1314
     * @return Masterlist
     */
    public function setDues1314($dues1314)
    {
        $this->dues1314 = $dues1314;

        return $this;
    }

    /**
     * Get dues1314
     *
     * @return integer 
     */
    public function getDues1314()
    {
        return $this->dues1314;
    }

    /**
     * Set dtrcvd1314
     *
     * @param \DateTime $dtrcvd1314
     * @return Masterlist
     */
    public function setDtrcvd1314($dtrcvd1314)
    {
        $this->dtrcvd1314 = $dtrcvd1314;

        return $this;
    }

    /**
     * Get dtrcvd1314
     *
     * @return \DateTime 
     */
    public function getDtrcvd1314()
    {
        return $this->dtrcvd1314;
    }

    /**
     * Set deposit1314
     *
     * @param \DateTime $deposit1314
     * @return Masterlist
     */
    public function setDeposit1314($deposit1314)
    {
        $this->deposit1314 = $deposit1314;

        return $this;
    }

    /**
     * Get deposit1314
     *
     * @return \DateTime 
     */
    public function getDeposit1314()
    {
        return $this->deposit1314;
    }

    /**
     * Set sendcard1314
     *
     * @param \DateTime $sendcard1314
     * @return Masterlist
     */
    public function setSendcard1314($sendcard1314)
    {
        $this->sendcard1314 = $sendcard1314;

        return $this;
    }

    /**
     * Get sendcard1314
     *
     * @return \DateTime 
     */
    public function getSendcard1314()
    {
        return $this->sendcard1314;
    }

    /**
     * Set comments1314
     *
     * @param string $comments1314
     * @return Masterlist
     */
    public function setComments1314($comments1314)
    {
        $this->comments1314 = $comments1314;

        return $this;
    }

    /**
     * Get comments1314
     *
     * @return string 
     */
    public function getComments1314()
    {
        return $this->comments1314;
    }

    /**
     * Set twocards
     *
     * @param string $twocards
     * @return Masterlist
     */
    public function setTwocards($twocards)
    {
        $this->twocards = $twocards;

        return $this;
    }

    /**
     * Get twocards
     *
     * @return string 
     */
    public function getTwocards()
    {
        return $this->twocards;
    }

    /**
     * Set dues1112
     *
     * @param string $dues1112
     * @return Masterlist
     */
    public function setDues1112($dues1112)
    {
        $this->dues1112 = $dues1112;

        return $this;
    }

    /**
     * Get dues1112
     *
     * @return string 
     */
    public function getDues1112()
    {
        return $this->dues1112;
    }

    /**
     * Set deposit1112
     *
     * @param string $deposit1112
     * @return Masterlist
     */
    public function setDeposit1112($deposit1112)
    {
        $this->deposit1112 = $deposit1112;

        return $this;
    }

    /**
     * Get deposit1112
     *
     * @return string 
     */
    public function getDeposit1112()
    {
        return $this->deposit1112;
    }

    /**
     * Set sendcard1112
     *
     * @param \DateTime $sendcard1112
     * @return Masterlist
     */
    public function setSendcard1112($sendcard1112)
    {
        $this->sendcard1112 = $sendcard1112;

        return $this;
    }

    /**
     * Get sendcard1112
     *
     * @return \DateTime 
     */
    public function getSendcard1112()
    {
        return $this->sendcard1112;
    }

    /**
     * Set dtrcvd1112
     *
     * @param \DateTime $dtrcvd1112
     * @return Masterlist
     */
    public function setDtrcvd1112($dtrcvd1112)
    {
        $this->dtrcvd1112 = $dtrcvd1112;

        return $this;
    }

    /**
     * Get dtrcvd1112
     *
     * @return \DateTime 
     */
    public function getDtrcvd1112()
    {
        return $this->dtrcvd1112;
    }

    /**
     * Set comments1112
     *
     * @param string $comments1112
     * @return Masterlist
     */
    public function setComments1112($comments1112)
    {
        $this->comments1112 = $comments1112;

        return $this;
    }

    /**
     * Get comments1112
     *
     * @return string 
     */
    public function getComments1112()
    {
        return $this->comments1112;
    }

    /**
     * Set umrarole
     *
     * @param integer $umrarole
     * @return Masterlist
     */
    public function setUmrarole($umrarole)
    {
        $this->umrarole = $umrarole;

        return $this;
    }

    /**
     * Get umrarole
     *
     * @return integer 
     */
    public function getUmrarole()
    {
        return $this->umrarole;
    }

    /**
     * Set dues1213
     *
     * @param integer $dues1213
     * @return Masterlist
     */
    public function setDues1213($dues1213)
    {
        $this->dues1213 = $dues1213;

        return $this;
    }

    /**
     * Get dues1213
     *
     * @return integer 
     */
    public function getDues1213()
    {
        return $this->dues1213;
    }

    /**
     * Set lunchprepay
     *
     * @param integer $lunchprepay
     * @return Masterlist
     */
    public function setLunchprepay($lunchprepay)
    {
        $this->lunchprepay = $lunchprepay;

        return $this;
    }

    /**
     * Get lunchprepay
     *
     * @return integer 
     */
    public function getLunchprepay()
    {
        return $this->lunchprepay;
    }

    /**
     * Set deposit1213
     *
     * @param \DateTime $deposit1213
     * @return Masterlist
     */
    public function setDeposit1213($deposit1213)
    {
        $this->deposit1213 = $deposit1213;

        return $this;
    }

    /**
     * Get deposit1213
     *
     * @return \DateTime 
     */
    public function getDeposit1213()
    {
        return $this->deposit1213;
    }

    /**
     * Set sendcard1213
     *
     * @param \DateTime $sendcard1213
     * @return Masterlist
     */
    public function setSendcard1213($sendcard1213)
    {
        $this->sendcard1213 = $sendcard1213;

        return $this;
    }

    /**
     * Get sendcard1213
     *
     * @return \DateTime 
     */
    public function getSendcard1213()
    {
        return $this->sendcard1213;
    }

    /**
     * Set dtrcvd1213
     *
     * @param \DateTime $dtrcvd1213
     * @return Masterlist
     */
    public function setDtrcvd1213($dtrcvd1213)
    {
        $this->dtrcvd1213 = $dtrcvd1213;

        return $this;
    }

    /**
     * Get dtrcvd1213
     *
     * @return \DateTime 
     */
    public function getDtrcvd1213()
    {
        return $this->dtrcvd1213;
    }

    /**
     * Set comments1213
     *
     * @param string $comments1213
     * @return Masterlist
     */
    public function setComments1213($comments1213)
    {
        $this->comments1213 = $comments1213;

        return $this;
    }

    /**
     * Get comments1213
     *
     * @return string 
     */
    public function getComments1213()
    {
        return $this->comments1213;
    }

    /**
     * Set usealtaddress
     *
     * @param string $usealtaddress
     * @return Masterlist
     */
    public function setUsealtaddress($usealtaddress)
    {
        $this->usealtaddress = $usealtaddress;

        return $this;
    }

    /**
     * Get usealtaddress
     *
     * @return string 
     */
    public function getUsealtaddress()
    {
        return $this->usealtaddress;
    }

    /**
     * Set altaddress
     *
     * @param string $altaddress
     * @return Masterlist
     */
    public function setAltaddress($altaddress)
    {
        $this->altaddress = $altaddress;

        return $this;
    }

    /**
     * Get altaddress
     *
     * @return string 
     */
    public function getAltaddress()
    {
        return $this->altaddress;
    }

    /**
     * Set altcity
     *
     * @param string $altcity
     * @return Masterlist
     */
    public function setAltcity($altcity)
    {
        $this->altcity = $altcity;

        return $this;
    }

    /**
     * Get altcity
     *
     * @return string 
     */
    public function getAltcity()
    {
        return $this->altcity;
    }

    /**
     * Set altstate
     *
     * @param string $altstate
     * @return Masterlist
     */
    public function setAltstate($altstate)
    {
        $this->altstate = $altstate;

        return $this;
    }

    /**
     * Get altstate
     *
     * @return string 
     */
    public function getAltstate()
    {
        return $this->altstate;
    }

    /**
     * Set altzip
     *
     * @param string $altzip
     * @return Masterlist
     */
    public function setAltzip($altzip)
    {
        $this->altzip = $altzip;

        return $this;
    }

    /**
     * Get altzip
     *
     * @return string 
     */
    public function getAltzip()
    {
        return $this->altzip;
    }

    /**
     * Set altphone
     *
     * @param string $altphone
     * @return Masterlist
     */
    public function setAltphone($altphone)
    {
        $this->altphone = $altphone;

        return $this;
    }

    /**
     * Get altphone
     *
     * @return string 
     */
    public function getAltphone()
    {
        return $this->altphone;
    }

    /**
     * Set yrjoin
     *
     * @param integer $yrjoin
     * @return Masterlist
     */
    public function setYrjoin($yrjoin)
    {
        $this->yrjoin = $yrjoin;

        return $this;
    }

    /**
     * Get yrjoin
     *
     * @return integer 
     */
    public function getYrjoin()
    {
        return $this->yrjoin;
    }

    /**
     * Set first
     *
     * @param string $first
     * @return Masterlist
     */
    public function setFirst($first)
    {
        $this->first = $first;

        return $this;
    }

    /**
     * Get first
     *
     * @return string 
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Set last
     *
     * @param string $last
     * @return Masterlist
     */
    public function setLast($last)
    {
        $this->last = $last;

        return $this;
    }

    /**
     * Get last
     *
     * @return string 
     */
    public function getLast()
    {
        return $this->last;
    }
}
