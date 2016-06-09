<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PostBundle\Entity\PostRepository")
 */
class Sitemap
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
     * @ORM\Column(name="title", type="text")
     */
    private $loc;
    /**
     * @var string
     *
     * @ORM\Column(name="changefreq", type="string", length=20)
     */
    private $changefreq;
    /**
     * @var string
     *
     * @ORM\Column(name="priority", type="string", length=40)
     */
    private $priority;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastmod", type="datetime",nullable=true)
     */
    private $lastmod;

    public function __construct()
    {
        $this->changefreq = "monthly";
        $this->priority = "0.5";
        $this->lastmod = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * @return string
     */
    public function getChangefreq()
    {
        return $this->changefreq;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return \DateTime
     */
    public function getLastmod()
    {
        return $this->lastmod;
    }

    /**
     * @param string $loc
     */
    public function setLoc($loc)
    {
        $this->loc = $loc;
    }

    /**
     * @param string $changefreq
     */
    public function setChangefreq($changefreq)
    {
        $this->changefreq = $changefreq;
    }

    /**
     * @param \DateTime $lastmod
     */
    public function setLastmod($lastmod)
    {
        $this->lastmod = $lastmod;
    }

    /**
     * @param string $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }


}
