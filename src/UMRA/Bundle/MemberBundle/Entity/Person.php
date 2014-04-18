<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Person
 *
 * @ORM\Table(name="person", indexes={@ORM\Index(name="HouseholdID", columns={"HouseholdID"})})
 * @UniqueEntity(fields={"x500"}, message="A user with the specified X.500 already exists.")
 * @ORM\Entity(repositoryClass="UMRA\Bundle\MemberBundle\Entity\PersonRepository")
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
     * @ORM\Column(name="x500", type="string", length=15, nullable=False, unique=True)
     */
    private $x500;

    /**
     * @var string
     *
     * @ORM\Column(name="Nickname", type="string", length=35, nullable=false)
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
     * @ORM\Column(name="Postalname", type="string", length=70, nullable=false)
     */
    private $postalname;

    /**
     * @var string
     *
     * @ORM\Column(name="Nametagname", type="string", length=20, nullable=false)
     */
    private $nametagname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Membersince", type="date", nullable=true)
     */
    private $membersince;

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
     * @var \DateTime
     *
     * @ORM\Column(name="URetiredate", type="date", nullable=true)
     */
    private $uretiredate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Deceasedate", type="date", nullable=true)
     */
    private $deceasedate;

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
     * @var \UMRA\Bundle\MemberBundle\Entity\Household
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Household", inversedBy="persons")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="HouseholdID", referencedColumnName="id")
     * })
     */
    private $household;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\OneToMany(targetEntity="Email", mappedBy="person", cascade={"persist", "remove"})
     */
    private $emails;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\OneToMany(targetEntity="Phone", mappedBy="person", cascade={"persist", "remove"})
     */
    private $phones;

    /**
     * @var string
     *
     */
    protected $email;

    /**
     * @var string
     *
     */
    protected $emailCanonical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    protected $enabled;

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

    public function __construct() {
        parent::__construct();
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
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

    /**
     * Set x500
     *
     * @param string $x500
     * @return Person
     */
    public function setX500($x500)
    {
        $this->x500 = $x500;

        return $this;
    }

    /**
     * Get x500
     *
     * @return string
     */
    public function getX500()
    {
        return $this->x500;
    }

    // For compatibility with FOSUserBundle
    public function setUsername($x500)
    {
        $this->x500;

        return $this;
    }

    public function getUsername()
    {
        return $this->x500;
    }

    public function setUsernameCanonical($x500)
    {
        $this->x500;

        return $this;
    }

    public function getUsernameCanonical()
    {
        return $this->x500;
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
     * Set postalname
     *
     * @param string $postalname
     * @return Person
     */
    public function setPostalname($postalname)
    {
        $this->postalname = $postalname;

        return $this;
    }

    /**
     * Get postalname
     *
     * @return string
     */
    public function getPostalname()
    {
        return $this->postalname;
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
     * @param \UMRA\Bundle\MemberBundle\Entity\Household $householdid
     * @return Person
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
     * Add email
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Email $email
     * @return Residence
     */
    public function addEmail(\UMRA\Bundle\MemberBundle\Entity\Email $email)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove email
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Email $emails
     */
    public function removeEmail(\UMRA\Bundle\MemberBundle\Entity\Email $email)
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
     * @param \UMRA\Bundle\MemberBundle\Entity\Phone $email
     * @return Person
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
