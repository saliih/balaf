<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Category
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category", cascade={"persist"})
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="children", cascade={"persist"})
     */
    private $parent;
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="parent")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $children;
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
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parent = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Add posts
     *
     * @param \PostBundle\Entity\Post $posts
     * @return Category
     */
    public function addPost(\PostBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \PostBundle\Entity\Post $posts
     */
    public function removePost(\PostBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add parent
     *
     * @param \PostBundle\Entity\Category $parent
     * @return Category
     */
    public function addParent(\PostBundle\Entity\Category $parent)
    {
        $this->parent[] = $parent;

        return $this;
    }

    /**
     * Remove parent
     *
     * @param \PostBundle\Entity\Category $parent
     */
    public function removeParent(\PostBundle\Entity\Category $parent)
    {
        $this->parent->removeElement($parent);
    }

    /**
     * Get parent
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set children
     *
     * @param \PostBundle\Entity\Category $children
     * @return Category
     */
    public function setChildren(\PostBundle\Entity\Category $children = null)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return \PostBundle\Entity\Category 
     */
    public function getChildren()
    {
        return $this->children;
    }
}
