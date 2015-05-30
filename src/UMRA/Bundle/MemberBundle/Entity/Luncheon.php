<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Luncheon
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UMRA\Bundle\MemberBundle\Entity\LuncheonRepository")
 */
class Luncheon
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="luncheon_date", type="date")
     */
    private $luncheonDate;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="registration_open", type="boolean")
     */
    private $registrationOpen;

    /**
     * @var Trans
     *
     * @ORM\OneToMany(targetEntity="Trans", mappedBy="luncheon")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf("%s - $%.2f per person", $this->getLuncheonDate()->format("F Y"), $this->getPrice());
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
     * Set luncheonDate
     *
     * @param \DateTime $luncheonDate
     *
     * @return Luncheon
     */
    public function setLuncheonDate($luncheonDate)
    {
        $this->luncheonDate = $luncheonDate;

        return $this;
    }

    /**
     * Get luncheonDate
     *
     * @return \DateTime
     */
    public function getLuncheonDate()
    {
        return $this->luncheonDate;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Luncheon
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set registrationOpen
     *
     * @param boolean $registrationOpen
     *
     * @return Luncheon
     */
    public function setRegistrationOpen($registrationOpen)
    {
        $this->registrationOpen = $registrationOpen;

        return $this;
    }

    /**
     * Get registrationOpen
     *
     * @return boolean
     */
    public function isRegistrationOpen()
    {
        return $this->registrationOpen;
    }

    /**
     * Add transaction
     *
     * @param Trans $transaction
     * @return Luncheon
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
}

