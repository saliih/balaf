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
     * @var string
     *
     * @ORM\Column(name="shortlink", type="string",nullable=true)
     */
    private $shortlink;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="Post")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", inversedBy="Post")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $createdby;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="created", type="date",nullable=true)
     */
    private $created;
    /**
     * @var \Date
     *
     * @ORM\Column(name="updated", type="date",nullable=true)
     */
    private $updated;
    /**
     * @var \Date
     *
     * @ORM\Column(name="publieddate", type="date",nullable=true)
     */
    private $publieddate;
    /**
     * @var Boolean
     *
     * @ORM\Column(name="enabled", type="boolean",nullable=true)
     */
    private $enabled;
    /**
     * @var Boolean
     *
     * @ORM\Column(name="twitter", type="boolean",nullable=true)
     */
    private $twitter;
    /**
     * @var Boolean
     *
     * @ORM\Column(name="ramadan2017", type="boolean",nullable=true)
     */
    private $ramadan2017;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbview", type="integer",nullable=true)
     */
    private $nbview;
    /**
     * @ORM\OneToMany(targetEntity="Views", mappedBy="post", cascade={"persist"})
     */
    private $view;
    public function __toString()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->twitter=false;
        $this->ramadan2017 = false;
        $this->enabled = false;
        $this->created = new \DateTime();
        $this->publieddate = new \DateTime();
        $this->view = new \Doctrine\Common\Collections\ArrayCollection();
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
        if($enabled){
            $this->created = new \DateTime();
        }
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
     * Set nbview
     *
     * @param integer $nbview
     * @return Post
     */
    public function setNbview($nbview)
    {
        $this->nbview = $nbview;

        return $this;
    }

    /**
     * Get nbview
     *
     * @return integer 
     */
    public function getNbview()
    {
        return $this->nbview;
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

    /**
     * Set createdby
     *
     * @param \Application\Sonata\UserBundle\Entity\User $createdby
     * @return Post
     */
    public function setCreatedby(\Application\Sonata\UserBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set ramadan2017
     *
     * @param boolean $ramadan2017
     * @return Post
     */
    public function setRamadan2017($ramadan2017)
    {
        $this->ramadan2017 = $ramadan2017;

        return $this;
    }

    /**
     * Get ramadan2017
     *
     * @return boolean 
     */
    public function getRamadan2017()
    {
        return $this->ramadan2017;
    }

    /**
     * Add view
     *
     * @param \PostBundle\Entity\Views $view
     * @return Post
     */
    public function addView(\PostBundle\Entity\Views $view)
    {
        $this->view[] = $view;

        return $this;
    }

    /**
     * Remove view
     *
     * @param \PostBundle\Entity\Views $view
     */
    public function removeView(\PostBundle\Entity\Views $view)
    {
        $this->view->removeElement($view);
    }

    /**
     * Get view
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return boolean
     */
    public function isTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param boolean $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return mixed
     */
    public function getShortlink()
    {
        return $this->shortlink;
    }

    /**
     * @param mixed $shortlink
     */
    public function setShortlink($shortlink)
    {
        $this->shortlink = $shortlink;
    }


    /**
     * Get twitter
     *
     * @return boolean 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }
}
