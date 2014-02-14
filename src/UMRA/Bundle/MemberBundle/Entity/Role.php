<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Fromdate", type="date", nullable=false)
     */
    private $fromdate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Todate", type="date", nullable=true)
     */
    private $todate;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=20, nullable=true)
     */
    private $description;

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
     * Set fromdate
     *
     * @param \DateTime $fromdate
     * @return Role
     */
    public function setFromdate($fromdate)
    {
        $this->fromdate = $fromdate;

        return $this;
    }

    /**
     * Get fromdate
     *
     * @return \DateTime 
     */
    public function getFromdate()
    {
        return $this->fromdate;
    }

    /**
     * Set todate
     *
     * @param \DateTime $todate
     * @return Role
     */
    public function setTodate($todate)
    {
        $this->todate = $todate;

        return $this;
    }

    /**
     * Get todate
     *
     * @return \DateTime 
     */
    public function getTodate()
    {
        return $this->todate;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Role
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
