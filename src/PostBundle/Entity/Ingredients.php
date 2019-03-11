<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredients
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Ingredients
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="subtitle", type="boolean")
     */
    private $subtitle;

    /**
     * @var integer
     *
     * @ORM\Column(name="ord", type="integer")
     */
    private $ord;
    /**
     * @var \Post
     *
     * @ORM\ManyToOne(targetEntity="PostBundle\Entity\Post")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="cascade")
     * })
     */
    private $post;

    public function __construct()
    {
        $this->ord = 0;
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
     * Set name
     *
     * @param string $name
     * @return Ingredients
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set subtitle
     *
     * @param boolean $subtitle
     * @return Ingredients
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return boolean 
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set ord
     *
     * @param integer $ord
     * @return Ingredients
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get ord
     *
     * @return integer 
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Set post
     *
     * @param \PostBundle\Entity\Post $post
     * @return Ingredients
     */
    public function setPost(\PostBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }
}
