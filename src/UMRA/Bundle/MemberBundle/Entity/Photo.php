<?php

namespace UMRA\Bundle\MemberBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 *
 * @ORM\Table(name="photo")
 * @ORM\Entity
 */
class Photo
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Datetaken", type="date", nullable=true)
     */
    private $datetaken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Dateadded", type="date", nullable=false)
     */
    private $dateadded;

    /**
     * @var string
     *
     * @ORM\Column(name="Caption", type="string", length=20, nullable=true)
     */
    private $caption;

    /**
     * @var string
     *
     * @ORM\Column(name="Content", type="blob", nullable=true)
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set datetaken
     *
     * @param \DateTime $datetaken
     * @return Photo
     */
    public function setDatetaken($datetaken)
    {
        $this->datetaken = $datetaken;

        return $this;
    }

    /**
     * Get datetaken
     *
     * @return \DateTime 
     */
    public function getDatetaken()
    {
        return $this->datetaken;
    }

    /**
     * Set dateadded
     *
     * @param \DateTime $dateadded
     * @return Photo
     */
    public function setDateadded($dateadded)
    {
        $this->dateadded = $dateadded;

        return $this;
    }

    /**
     * Get dateadded
     *
     * @return \DateTime 
     */
    public function getDateadded()
    {
        return $this->dateadded;
    }

    /**
     * Set caption
     *
     * @param string $caption
     * @return Photo
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
     * Get caption
     *
     * @return string 
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Photo
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
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
