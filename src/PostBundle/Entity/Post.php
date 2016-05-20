<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PostBundle\Entity\PostRepository")
 */
class Post
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
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255,nullable=true,unique=true)
     */
    private $alias;
    /**
     * @var string
     *
     * @ORM\Column(name="pic", type="string", length=255,nullable=true)
     */
    private $pic;
    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=2)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text",nullable=true)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="Post")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $category;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime",nullable=true)
     */
    private $created;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime",nullable=true)
     */
    private $updated;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publieddate", type="datetime",nullable=true)
     */
    private $publieddate;
    /**
     * @var Boolean
     *
     * @ORM\Column(name="enabled", type="boolean",nullable=true)
     */
    private $enabled;

    public function __construct()
    {
        $this->enabled = false;
        $this->created = new \DateTime();
    }

    public function __toString()
    {
        return $this->title;
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
     * @return Post
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
     * Set alias
     *
     * @param string $alias
     * @return Post
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set pic
     *
     * @param string $pic
     * @return Post
     */
    public function setPic($pic)
    {
        $this->pic = $pic;

        return $this;
    }

    /**
     * Get pic
     *
     * @return string 
     */
    public function getPic()
    {
        return $this->pic;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * @return Post
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set article
     *
     * @param string $article
     * @return Post
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Post
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Post
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set publieddate
     *
     * @param \DateTime $publieddate
     * @return Post
     */
    public function setPublieddate($publieddate)
    {
        $this->publieddate = $publieddate;

        return $this;
    }

    /**
     * Get publieddate
     *
     * @return \DateTime 
     */
    public function getPublieddate()
    {
        return $this->publieddate;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Post
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set category
     *
     * @param \PostBundle\Entity\Category $category
     * @return Post
     */
    public function setCategory(\PostBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \PostBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
