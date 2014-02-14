<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MemberList
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MemberList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="MemberID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $memberID;

    /**
     * @var string
     *
     * @ORM\Column(name="LastName", type="string", length=60)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="FirstName", type="string", length=60)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="FullName", type="string", length=120)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="MailName", type="string", length=120)
     */
    private $mailName;

    /**
     * @var string
     *
     * @ORM\Column(name="LabelName", type="string", length=120)
     */
    private $labelName;

    /**
     * @var string
     *
     * @ORM\Column(name="SSOFullName", type="string", length=120)
     */
    private $sSOFullName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="MemberSince", type="date")
     */
    private $memberSince;

    /**
     * @var string
     *
     * @ORM\Column(name="UtopUnit", type="string", length=60)
     */
    private $utopUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="UDeptEquiv", type="string", length=60)
     */
    private $uDeptEquiv;

    /**
     * @var string
     *
     * @ORM\Column(name="UEmplType", type="string", length=60)
     */
    private $uEmplType;

    /**
     * @var string
     *
     * @ORM\Column(name="UTitle", type="string", length=60)
     */
    private $uTitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UStartDate", type="date")
     */
    private $uStartDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="URetireDate", type="date")
     */
    private $uRetireDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="JoinDate", type="date")
     */
    private $joinDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DeceasedDate", type="date")
     */
    private $deceasedDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="MailNewsLetter", type="boolean")
     */
    private $mailNewsLetter;

    /**
     * @var string
     *
     * @ORM\Column(name="WebPage", type="string", length=255)
     */
    private $webPage;

    /**
     * @var string
     *
     * @ORM\Column(name="Comment", type="string", length=4000)
     */
    private $comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="PartnerMemberID", type="integer")
     */
    private $partnerMemberID;


    /**
     * Get memberID
     *
     * @return integer 
     */
    public function getMemberID()
    {
        return $this->memberID;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return MemberList
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return MemberList
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return MemberList
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set mailName
     *
     * @param string $mailName
     * @return MemberList
     */
    public function setMailName($mailName)
    {
        $this->mailName = $mailName;

        return $this;
    }

    /**
     * Get mailName
     *
     * @return string 
     */
    public function getMailName()
    {
        return $this->mailName;
    }

    /**
     * Set labelName
     *
     * @param string $labelName
     * @return MemberList
     */
    public function setLabelName($labelName)
    {
        $this->labelName = $labelName;

        return $this;
    }

    /**
     * Get labelName
     *
     * @return string 
     */
    public function getLabelName()
    {
        return $this->labelName;
    }

    /**
     * Set sSOFullName
     *
     * @param string $sSOFullName
     * @return MemberList
     */
    public function setSSOFullName($sSOFullName)
    {
        $this->sSOFullName = $sSOFullName;

        return $this;
    }

    /**
     * Get sSOFullName
     *
     * @return string 
     */
    public function getSSOFullName()
    {
        return $this->sSOFullName;
    }

    /**
     * Set memberSince
     *
     * @param \DateTime $memberSince
     * @return MemberList
     */
    public function setMemberSince($memberSince)
    {
        $this->memberSince = $memberSince;

        return $this;
    }

    /**
     * Get memberSince
     *
     * @return \DateTime 
     */
    public function getMemberSince()
    {
        return $this->memberSince;
    }

    /**
     * Set utopUnit
     *
     * @param string $utopUnit
     * @return MemberList
     */
    public function setUtopUnit($utopUnit)
    {
        $this->utopUnit = $utopUnit;

        return $this;
    }

    /**
     * Get utopUnit
     *
     * @return string 
     */
    public function getUtopUnit()
    {
        return $this->utopUnit;
    }

    /**
     * Set uDeptEquiv
     *
     * @param string $uDeptEquiv
     * @return MemberList
     */
    public function setUDeptEquiv($uDeptEquiv)
    {
        $this->uDeptEquiv = $uDeptEquiv;

        return $this;
    }

    /**
     * Get uDeptEquiv
     *
     * @return string 
     */
    public function getUDeptEquiv()
    {
        return $this->uDeptEquiv;
    }

    /**
     * Set uEmplType
     *
     * @param string $uEmplType
     * @return MemberList
     */
    public function setUEmplType($uEmplType)
    {
        $this->uEmplType = $uEmplType;

        return $this;
    }

    /**
     * Get uEmplType
     *
     * @return string 
     */
    public function getUEmplType()
    {
        return $this->uEmplType;
    }

    /**
     * Set uTitle
     *
     * @param string $uTitle
     * @return MemberList
     */
    public function setUTitle($uTitle)
    {
        $this->uTitle = $uTitle;

        return $this;
    }

    /**
     * Get uTitle
     *
     * @return string 
     */
    public function getUTitle()
    {
        return $this->uTitle;
    }

    /**
     * Set uStartDate
     *
     * @param \DateTime $uStartDate
     * @return MemberList
     */
    public function setUStartDate($uStartDate)
    {
        $this->uStartDate = $uStartDate;

        return $this;
    }

    /**
     * Get uStartDate
     *
     * @return \DateTime 
     */
    public function getUStartDate()
    {
        return $this->uStartDate;
    }

    /**
     * Set uRetireDate
     *
     * @param \DateTime $uRetireDate
     * @return MemberList
     */
    public function setURetireDate($uRetireDate)
    {
        $this->uRetireDate = $uRetireDate;

        return $this;
    }

    /**
     * Get uRetireDate
     *
     * @return \DateTime 
     */
    public function getURetireDate()
    {
        return $this->uRetireDate;
    }

    /**
     * Set joinDate
     *
     * @param \DateTime $joinDate
     * @return MemberList
     */
    public function setJoinDate($joinDate)
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    /**
     * Get joinDate
     *
     * @return \DateTime 
     */
    public function getJoinDate()
    {
        return $this->joinDate;
    }

    /**
     * Set deceasedDate
     *
     * @param \DateTime $deceasedDate
     * @return MemberList
     */
    public function setDeceasedDate($deceasedDate)
    {
        $this->deceasedDate = $deceasedDate;

        return $this;
    }

    /**
     * Get deceasedDate
     *
     * @return \DateTime 
     */
    public function getDeceasedDate()
    {
        return $this->deceasedDate;
    }

    /**
     * Set mailNewsLetter
     *
     * @param boolean $mailNewsLetter
     * @return MemberList
     */
    public function setMailNewsLetter($mailNewsLetter)
    {
        $this->mailNewsLetter = $mailNewsLetter;

        return $this;
    }

    /**
     * Get mailNewsLetter
     *
     * @return boolean 
     */
    public function getMailNewsLetter()
    {
        return $this->mailNewsLetter;
    }

    /**
     * Set webPage
     *
     * @param string $webPage
     * @return MemberList
     */
    public function setWebPage($webPage)
    {
        $this->webPage = $webPage;

        return $this;
    }

    /**
     * Get webPage
     *
     * @return string 
     */
    public function getWebPage()
    {
        return $this->webPage;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return MemberList
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set partnerMemberID
     *
     * @param integer $partnerMemberID
     * @return MemberList
     */
    public function setPartnerMemberID($partnerMemberID)
    {
        $this->partnerMemberID = $partnerMemberID;

        return $this;
    }

    /**
     * Get partnerMemberID
     *
     * @return integer 
     */
    public function getPartnerMemberID()
    {
        return $this->partnerMemberID;
    }
}
