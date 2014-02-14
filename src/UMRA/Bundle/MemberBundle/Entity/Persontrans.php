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
    private $trans;

    /**
     * @var \UMRA\Bundle\MemberBundle\Entity\Person
     *
     * @ORM\ManyToOne(targetEntity="UMRA\Bundle\MemberBundle\Entity\Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="PersonID", referencedColumnName="id")
     * })
     */
    private $person;



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
     * Set trans
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Trans $trans
     * @return Persontrans
     */
    public function setTrans(\UMRA\Bundle\MemberBundle\Entity\Trans $trans = null)
    {
        $this->trans = $trans;

        return $this;
    }

    /**
     * Get trans
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Trans
     */
    public function getTrans()
    {
        return $this->trans;
    }

    /**
     * Set person
     *
     * @param \UMRA\Bundle\MemberBundle\Entity\Person $person
     * @return Persontrans
     */
    public function setPerson(\UMRA\Bundle\MemberBundle\Entity\Person $person = null)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return \UMRA\Bundle\MemberBundle\Entity\Person
     */
    public function getPerson()
    {
        return $this->person;
    }
}
