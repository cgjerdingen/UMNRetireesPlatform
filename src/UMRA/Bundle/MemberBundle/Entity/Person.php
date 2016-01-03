<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="HouseholdID", columns={"HouseholdID"})})
 * @ORM\Entity(repositoryClass="UMRA\Bundle\MemberBundle\Entity\PersonRepository")
 * @UniqueEntity("emailCanonical")
 */
class Person extends BaseUser
{
    /**
     * @var string
     *
     * @ORM\Column(name="Lastname", type="string", length=35, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="Firstname", type="string", length=35, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="Nickname", type="string", length=35, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="Fullname", type="string", length=70, nullable=false)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="Nametagname", type="string", length=20, nullable=true)
     */
    private $nametagname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Membersince", type="date", nullable=true)
     */
    private $membersince;

    /**
     * @var boolean
     *
     * @ORM\Column(name="memSinceDayIndeter", type="boolean", nullable=true)
     */
    private $memSinceDayIndeterminate = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="memSinceMonthIndeter", type="boolean", nullable=true)
     */
    private $memSinceMonthIndeterminate = false;

    /**
     * @var string
     *
     * @ORM\Column(name="UTopUnit", type="string", length=35, nullable=true)
     */
    private $utopunit;

    /**
     * @var string
     *
     * @ORM\Column(name="UDeptEquiv", type="string", length=35, nullable=true)
     */
    private $udeptequiv;

    /**
     * @var string
     *
     * @ORM\Column(name="UEmplType", type="string", length=20, nullable=true)
     */
    private $uempltype;

    /**
     * @var string
     *
     * @ORM\Column(name="UTitle", type="string", length=35, nullable=true)
     */
    private $utitle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="UStartdate", type="date", nullable=true)
     */
    private $ustartdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="UStartDayIndeter", type="boolean", nullable=true)
     */
    private $ustartDayIndeterminate = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="UStartMonthIndeter", type="boolean", nullable=true)
     */
    private $ustartMonthIndeterminate = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="URetiredate", type="date", nullable=true)
     */
    private $uretiredate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="URetireDayIndeter", type="boolean", nullable=true)
     */
    private $uretireDayIndeterminate = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="URetireMonthIndeter", type="boolean", nullable=true)
     */
    private $uretireMonthIndeterminate = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Deceasedate", type="date", nullable=true)
     */
    private $deceasedate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Secondary", type="boolean", nullable=false)
     */
    private $secondary = false;

    /**
     * @var string
     *
     * @ORM\Column(name="Activenow", type="boolean", nullable=true)
     */
    private $activenow;

    /**
     * @var string
     * @Assert\Choice(choices={"", "postal", "email", "both"}, message="Must be postal, email, or both.")
     * @ORM\Column(name="news_pref", type="string", length=20, nullable=true)
     */
    private $newsPref;

    /**
     * @var string
     *
     * @ORM\Column(name="Weburl", type="string", length=255, nullable=true)
     */
    private $weburl;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Household
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Household", inversedBy="persons")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="HouseholdID", referencedColumnName="id")
     * })
     */
    private $household;

    /**
     * @var Trans
     *
     * @ORM\OneToMany(targetEntity="Trans", mappedBy="person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $transactions;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\OneToMany(targetEntity="Email", mappedBy="person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $emails;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $phones;

    /**
     * @var string
     *
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="email_canonical", type="string", length=255, nullable=True, unique=True)
     * @Assert\Email()
     */
    protected $emailCanonical;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string")
     */
    protected $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string")
     */
    protected $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="locked", type="boolean")
     */
    protected $locked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="expired", type="boolean")
     */
    protected $expired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime", nullable=true)
     */
    protected $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmation_token", type="string", nullable=true)
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="password_requested_at", type="datetime", nullable=true)
     */
    protected $passwordRequestedAt;

    /**
     * @var array
     * TODO: Change to ArrayCollection
     * @ORM\Column(name="roles", type="array")
     */
    protected $roles;

    /**
     * @var boolean
     *
     * @ORM\Column(name="credentials_expired", type="boolean")
     */
    protected $credentialsExpired;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="credentials_expire_at", type="datetime", nullable=true)
     */
    protected $credentialsExpireAt;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Luncheon", mappedBy="attendees")
     */
    protected $luncheons;

    public function __construct() {
        parent::__construct();
        $this->roles = array('ROLE_USER');
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->luncheons = new ArrayCollection();
    }

    public function __toString() {
        return $this->getFullname() . " (" . $this->getEmailCanonical() . ")";
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (!$this->isSecondary()) {
            $emailCanonical = $this->getEmailCanonical();
            if (empty($emailCanonical)) {
                $context->buildViolation('An email is required for UMRA members registering online')
                        ->atPath('emailCanonical')
                        ->addViolation();
            }

            $ustartdate = $this->getUstartdate();
            if (empty($ustartdate)) {
                $context->buildViolation('A University Start Date is required for UMRA members')
                    ->atPath('ustartdate')
                    ->addViolation();
            }

            $uretiredate = $this->getUretiredate();
            if (empty($uretiredate)) {
                $context->buildViolation('A University Retire Date is required for UMRA members')
                        ->atPath('uretiredate')
                        ->addViolation();
            }
        }
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Person
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    // For compatibility with FOSUserBundle
    public function setEmail($email)
    {
        $this->setEmailCanonical($email);

        return $this;
    }

    public function getEmail()
    {
        return $this->getEmailCanonical();
    }

    public function setEmailCanonical($email)
    {
        if ($email === '') $email = null;
        $this->emailCanonical = $email;

        return $this;
    }

    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * Set nickname
     *
     * @param string $nickname
     * @return Person
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return Person
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set nametagname
     *
     * @param string $nametagname
     * @return Person
     */
    public function setNametagname($nametagname)
    {
        $this->nametagname = $nametagname;

        return $this;
    }

    /**
     * Get nametagname
     *
     * @return string
     */
    public function getNametagname()
    {
        return $this->nametagname;
    }

    /**
     * Set membersince
     *
     * @param \DateTime $membersince
     * @return Person
     */
    public function setMembersince($membersince)
    {
        $this->membersince = $membersince;

        return $this;
    }

    /**
     * Get membersince
     *
     * @return \DateTime
     */
    public function getMembersince()
    {
        return $this->membersince;
    }

    /**
     * Set memSinceDayIndeterminate
     *
     * @return Person
     */
    public function setMemberSinceDayIndeterminate($memSinceDayIndeterminate)
    {
        $this->memSinceDayIndeterminate = $memSinceDayIndeterminate;

        return $this;
    }

    /**
     * Is memSinceDayIndeterminate?
     *
     * @return boolean
     */
    public function isMemberSinceDayIndeterminate()
    {
        return $this->memSinceDayIndeterminate;
    }

    /**
     * Set memSinceMonthIndeterminate
     *
     * @return Person
     */
    public function setMemberSinceMonthIndeterminate($memSinceMonthIndeterminate)
    {
        $this->memSinceMonthIndeterminate = $memSinceMonthIndeterminate;

        return $this;
    }

    /**
     * Is memSinceMonthIndeterminate?
     *
     * @return boolean
     */
    public function isMemberSinceMonthIndeterminate()
    {
        return $this->memSinceMonthIndeterminate;
    }

    /**
     * Set utopunit
     *
     * @param string $utopunit
     * @return Person
     */
    public function setUtopunit($utopunit)
    {
        $this->utopunit = $utopunit;

        return $this;
    }

    /**
     * Get utopunit
     *
     * @return string
     */
    public function getUtopunit()
    {
        return $this->utopunit;
    }

    /**
     * Set udeptequiv
     *
     * @param string $udeptequiv
     * @return Person
     */
    public function setUdeptequiv($udeptequiv)
    {
        $this->udeptequiv = $udeptequiv;

        return $this;
    }

    /**
     * Get udeptequiv
     *
     * @return string
     */
    public function getUdeptequiv()
    {
        return $this->udeptequiv;
    }

    /**
     * Set uempltype
     *
     * @param string $uempltype
     * @return Person
     */
    public function setUempltype($uempltype)
    {
        $this->uempltype = $uempltype;

        return $this;
    }

    /**
     * Get uempltype
     *
     * @return string
     */
    public function getUempltype()
    {
        return $this->uempltype;
    }

    /**
     * Set utitle
     *
     * @param string $utitle
     * @return Person
     */
    public function setUtitle($utitle)
    {
        $this->utitle = $utitle;

        return $this;
    }

    /**
     * Get utitle
     *
     * @return string
     */
    public function getUtitle()
    {
        return $this->utitle;
    }

    /**
     * Set ustartdate
     *
     * @param \DateTime $ustartdate
     * @return Person
     */
    public function setUstartdate($ustartdate)
    {
        $this->ustartdate = $ustartdate;

        return $this;
    }

    /**
     * Get ustartdate
     *
     * @return \DateTime
     */
    public function getUstartdate()
    {
        return $this->ustartdate;
    }

    /**
     * Set ustartDayIndeterminate
     *
     * @return Person
     */
    public function setUstartDayIndeterminate($ustartDayIndeterminate)
    {
        $this->ustartDayIndeterminate = $ustartDayIndeterminate;

        return $this;
    }

    /**
     * Is ustartDayIndeterminate?
     *
     * @return boolean
     */
    public function isUstartDayIndeterminate()
    {
        return $this->ustartDayIndeterminate;
    }

    /**
     * Set ustartMonthIndeterminate
     *
     * @return Person
     */
    public function setUstartMonthIndeterminate($ustartMonthIndeterminate)
    {
        $this->ustartMonthIndeterminate = $ustartMonthIndeterminate;

        return $this;
    }

    /**
     * Is ustartMonthIndeterminate?
     *
     * @return boolean
     */
    public function isUstartMonthIndeterminate()
    {
        return $this->ustartMonthIndeterminate;
    }

    /**
     * Set uretiredate
     *
     * @param \DateTime $uretiredate
     * @return Person
     */
    public function setUretiredate($uretiredate)
    {
        $this->uretiredate = $uretiredate;

        return $this;
    }

    /**
     * Get uretiredate
     *
     * @return \DateTime
     */
    public function getUretiredate()
    {
        return $this->uretiredate;
    }

    /**
     * Set uretireDayIndeterminate
     *
     * @return Person
     */
    public function setUretireDayIndeterminate($uretireDayIndeterminate)
    {
        $this->uretireDayIndeterminate = $uretireDayIndeterminate;

        return $this;
    }

    /**
     * Is uretireDayIndeterminate?
     *
     * @return boolean
     */
    public function isUretireDayIndeterminate()
    {
        return $this->uretireDayIndeterminate;
    }

    /**
     * Set uretireMonthIndeterminate
     *
     * @return Person
     */
    public function setUretireMonthIndeterminate($uretireMonthIndeterminate)
    {
        $this->uretireMonthIndeterminate = $uretireMonthIndeterminate;

        return $this;
    }

    /**
     * Is uretireMonthIndeterminate?
     *
     * @return boolean
     */
    public function isUretireMonthIndeterminate()
    {
        return $this->uretireMonthIndeterminate;
    }

    /**
     * Set deceasedate
     *
     * @param \DateTime $deceasedate
     * @return Person
     */
    public function setDeceasedate($deceasedate)
    {
        $this->deceasedate = $deceasedate;

        return $this;
    }

    /**
     * Get deceasedate
     *
     * @return \DateTime
     */
    public function getDeceasedate()
    {
        return $this->deceasedate;
    }

    /**
     * Set secondary
     *
     * @param boolean $secondary
     * @return Person
     */
    public function setSecondary($secondary)
    {
        $this->secondary = $secondary;

        return $this;
    }

    /**
     * Get secondary
     *
     * @return boolean
     */
    public function isSecondary()
    {
        return $this->secondary;
    }

    /**
     * Set activenow
     *
     * @param boolean $activenow
     * @return Person
     */
    public function setActivenow($activenow)
    {
        $this->activenow = $activenow;

        return $this;
    }

    /**
     * Get activenow
     *
     * @return boolean
     */
    public function isActivenow()
    {
        return $this->activenow;
    }

    /**
     * Set newsPref
     *
     * @param string $newsPref
     * @return Person
     */
    public function setNewsPref($newsPref)
    {
        $this->newsPref = $newsPref;

        return $this;
    }

    /**
     * Get newsPref
     *
     * @return string
     */
    public function getNewsPref()
    {
        return $this->newsPref;
    }

    /**
     * Set weburl
     *
     * @param string $weburl
     * @return Person
     */
    public function setWeburl($weburl)
    {
        $this->weburl = $weburl;

        return $this;
    }

    /**
     * Get weburl
     *
     * @return string
     */
    public function getWeburl()
    {
        return $this->weburl;
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
     * @param Household $household
     * @return Person
     */
    public function setHousehold(Household $household = null)
    {
        $this->household = $household;

        return $this;
    }

    /**
     * Get household
     *
     * @return Household
     */
    public function getHousehold()
    {
        return $this->household;
    }

    /**
     * Add transaction
     *
     * @param Trans $transaction
     * @return Residence
     */
    public function addTransaction(Trans $transaction)
    {
        $this->transactions[] = $transaction;

        return $this;
    }

    /**
     * Remove transaction
     *
     * @param Trans $transaction
     */
    public function removeTransaction(Trans $transaction)
    {
        $this->transactions->removeElement($transaction);
    }

    /**
     * Get transactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Add email
     *
     * @param Email $email
     * @return Residence
     */
    public function addEmail(Email $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove email
     *
     * @param Email $email
     */
    public function removeEmail(Email $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add phone
     *
     * @param Phone $phone
     * @return Person
     */
    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Remove phone
     *
     * @param Phone $phone
     */
    public function removePhone(Phone $phone)
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

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Person
     */
    public function setEnabled($enabled)
    {
        $this->activenow = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->activenow;
    }

    public function getAvatarUrl()
    {
        return sprintf("https://gravatar.com/avatar/%s", md5($this->emailCanonical));
    }

    public function setExpiresAt(\DateTime $expiresAt) {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getExpiresAt() {
        return $this->expiresAt;
    }

    public function setCredentialsExpireAt(\DateTime $credentialsExpireAt) {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    public function getCredentialsExpireAt() {
        return $this->credentialsExpireAt;
    }

    /**
     * Add luncheon
     *
     * @param Luncheon $luncheon
     * @return Person
     */
    public function addAttendee(Luncheon $luncheon)
    {
        $this->luncheons[] = $luncheon;

        return $this;
    }

    /**
     * Remove luncheon
     *
     * @param Luncheon $luncheon
     */
    public function removeAttendee(Luncheon $luncheon)
    {
        $this->luncheons->removeElement($luncheon);
    }

    /**
     * Get luncheons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLuncheons()
    {
        return $this->luncheons;
    }
}
