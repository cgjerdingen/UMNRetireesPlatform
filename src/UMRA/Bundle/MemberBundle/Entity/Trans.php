<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Trans
 *
 * @ORM\Table(name="trans")
 * @ORM\Entity(repositoryClass="UMRA\Bundle\MemberBundle\Entity\TransRepository")
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
     * @Assert\Choice(choices = {"MEMBERSHIP_NEW", "MEMBERSHIP_RENEW", "LUNCHEON_FEE", "PARKING_PASS", "OTHER"}, message = "Must be 'new membership', 'membership renewal', 'luncheon fee', 'parking pass' and 'other'.")
     * @ORM\Column(name="Trantype", type="string", length=20, nullable=false)
     */
    private $trantype;

    /**
     * @var string
     *
     * @ORM\Column(name="Amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $amount;

    /**
     * @var string
     *
     * @Assert\Choice(choices = {"CREDIT_CARD", "CHECK", "OTHER"}, message = "Must be credit card, check, or other.")
     * @ORM\Column(name="Pmtmethod", type="string", length=20, nullable=false)
     */
    private $pmtmethod;

    /**
     * @var string
     *
     * @ORM\Column(name="Servicechg", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $servicechg;

    /**
     * @var Person
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="doneby_id", referencedColumnName="id")
     * })
     */
    private $doneby;

    /**
     * @var string
     *
     * @ORM\Column(name="Notes", type="string", length=255, nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @Assert\Choice(choices = {"AWAITING_PROCESS", "PROCESSING", "PROCESSED"}, message = "Must be awaiting process, processing, or processed.")
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="reconciled_date", type="date", nullable=true)
     */
    private $reconciledDate;

    /**
     * @var string
     *
     * @ORM\Column(name="ProcTranID", type="string", length=255, nullable=true, options={"comment":"ID used by the payment processor to represent the transaction"})
     */
    private $procTranId;

    /**
     * @var string
     *
     * @ORM\Column(name="InvoiceID", type="string", length=255, nullable=true, options={"comment":"Invoice ID for tracking transactions with a payment processor"})
     */
    private $invoiceId;

    /**
     * @var Person
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person", inversedBy="transactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PersonID", referencedColumnName="id")
     * })
     */
    private $person;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Luncheon", inversedBy="transactions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LuncheonID", referencedColumnName="id")
     * })
     */
    private $luncheon;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    public function __toString()
    {
        $now = new \DateTime();
        $tranDateStr = $this->trandate instanceof \DateTime ? $this->trandate->format('Y-m-d') : $now->format('Y-m-d');
        $tranType = strlen($this->trantype) > 0 ? $this->trantype : "NEW";
        $pmtMethod = strlen($this->pmtmethod) > 0 ? " ($this->pmtmethod)" : "";
        return sprintf("%s - %s - $%.2f%s", $tranDateStr, $tranType, $this->amount, $pmtMethod);
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getTrantype() === "LUNCHEON_FEE") {
            if ($this->getLuncheon() === null) {
                $context->buildViolation('Luncheon transactions must have a luncheon associated with them.')
                        ->atPath('luncheon')
                        ->addViolation();
            }
        } else {
            if ($this->getLuncheon() !== null) {
                $context->buildViolation('Only luncheon transactions can have a luncheon associated with them.')
                        ->atPath('luncheon')
                        ->addViolation();
            }
        }
    }

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
     * @param float $amount
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
     * @return float
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
     * @param Person $doneby
     * @return Trans
     */
    public function setDoneby(Person $doneby = null)
    {
        $this->doneby = $doneby;

        return $this;
    }

    /**
     * Get doneby
     *
     * @return Person
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
     * Set person
     *
     * @param Person $person
     * @return Trans
     */
    public function setPerson(Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set luncheon
     *
     * @param Luncheon $luncheon
     * @return Trans
     */
    public function setLuncheon(Luncheon $luncheon = null)
    {
        $this->luncheon = $luncheon;

        return $this;
    }

    /**
     * Get luncheon
     *
     * @return Luncheon
     */
    public function getLuncheon()
    {
        return $this->luncheon;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Trans
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set reconciledDate
     *
     * @param \DateTime $reconciledDate
     * @return Trans
     */
    public function setReconciledDate($reconciledDate)
    {
        $this->reconciledDate = $reconciledDate;

        return $this;
    }

    /**
     * Get reconciledDate
     *
     * @return \DateTime
     */
    public function getReconciledDate()
    {
        return $this->reconciledDate;
    }

    /**
     * Set ProcTranID
     *
     * @param string $procTranId
     * @return Trans
     */
    public function setProcTranId($procTranId)
    {
        $this->procTranId = $procTranId;

        return $this;
    }

    /**
     * Get ProcTranID
     *
     * @return string
     */
    public function getProcTranId()
    {
        return $this->procTranId;
    }

    /**
     * Set invoiceId
     *
     * @param string $invoiceId
     * @return Trans
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    /**
     * Get invoiceId
     *
     * @return string
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
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
