<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
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
     * @Gedmo\Translatable
     * @ORM\Column(name="title_seo", type="string",length=160, nullable=true)
     */
    protected $titleSeo;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description_seo", type="string",length=255, nullable=true)
     */
    protected $descriptionSeo;
    /**
     * @var string
     *
     * @Gedmo\Translatable
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
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @var string
     *
     * @Gedmo\Translatable
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
     * @Gedmo\Translatable
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
     * @Gedmo\Translatable
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
     * @Gedmo\Translatable
     * @ORM\Column(name="nbview", type="integer",nullable=true)
     */
    private $nbview;
    /**
     * @ORM\OneToMany(targetEntity="Views", mappedBy="post", cascade={"persist"})
     */
    private $view;
    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * @param $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
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
     * Set shortlink
     *
     * @param string $shortlink
     * @return Post
     */
    public function setShortlink($shortlink)
    {
        $this->shortlink = $shortlink;

        return $this;
    }

    /**
     * Get shortlink
     *
     * @return string 
     */
    public function getShortlink()
    {
        return $this->shortlink;
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
     * Set twitter
     *
     * @param boolean $twitter
     * @return Post
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
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
     * Set titleSeo
     *
     * @param string $titleSeo
     * @return Post
     */
    public function setTitleSeo($titleSeo)
    {
        $this->titleSeo = $titleSeo;

        return $this;
    }

    /**
     * Get titleSeo
     *
     * @return string 
     */
    public function getTitleSeo()
    {
        return $this->titleSeo;
    }

    /**
     * Set descriptionSeo
     *
     * @param string $descriptionSeo
     * @return Post
     */
    public function setDescriptionSeo($descriptionSeo)
    {
        $this->descriptionSeo = $descriptionSeo;

        return $this;
    }

    /**
     * Get descriptionSeo
     *
     * @return string 
     */
    public function getDescriptionSeo()
    {
        return $this->descriptionSeo;
    }
}
