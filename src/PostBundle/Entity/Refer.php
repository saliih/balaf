<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Refer
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="Views", mappedBy="category", cascade={"persist"})
     */
    private $views;

    public function __toString()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->views = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Refer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add views
     *
     * @param \PostBundle\Entity\Views $views
     * @return Refer
     */
    public function addView(\PostBundle\Entity\Views $views)
    {
        $this->views[] = $views;

        return $this;
    }

    /**
     * Remove views
     *
     * @param \PostBundle\Entity\Views $views
     */
    public function removeView(\PostBundle\Entity\Views $views)
    {
        $this->views->removeElement($views);
    }

    /**
     * Get views
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getViews()
    {
        return $this->views;
    }
}
