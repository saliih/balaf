<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recettes
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recettes
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
     * @var \DateTime
     *
     * @ORM\Column(name="datepub", type="datetime")
     */
    private $datepub;

    /**
     * @var integer
     *
     * @ORM\Column(name="view", type="integer")
     */
    private $view;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="soupe_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $soupe;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="salad_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $salade;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="entree_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $entree;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="principal_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $principal;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="view")
     * @ORM\JoinColumn(name="patisserie_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $patisserie;

    public function __toString()
    {
        return (string)$this->datepub->format("d-m-Y");
    }
    public function __construct()
    {
        $this->datepub = new \DateTime();
        $this->view = 0;
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
     * Set datepub
     *
     * @param \DateTime $datepub
     * @return Recettes
     */
    public function setDatepub($datepub)
    {
        $this->datepub = $datepub;

        return $this;
    }

    /**
     * Get datepub
     *
     * @return \DateTime 
     */
    public function getDatepub()
    {
        return $this->datepub;
    }

    /**
     * Set soupe
     *
     * @param \PostBundle\Entity\Post $soupe
     * @return Recettes
     */
    public function setSoupe(\PostBundle\Entity\Post $soupe = null)
    {
        $this->soupe = $soupe;

        return $this;
    }

    /**
     * Get soupe
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getSoupe()
    {
        return $this->soupe;
    }

    /**
     * Set salade
     *
     * @param \PostBundle\Entity\Post $salade
     * @return Recettes
     */
    public function setSalade(\PostBundle\Entity\Post $salade = null)
    {
        $this->salade = $salade;

        return $this;
    }

    /**
     * Get salade
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getSalade()
    {
        return $this->salade;
    }

    /**
     * Set entree
     *
     * @param \PostBundle\Entity\Post $entree
     * @return Recettes
     */
    public function setEntree(\PostBundle\Entity\Post $entree = null)
    {
        $this->entree = $entree;

        return $this;
    }

    /**
     * Get entree
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * Set principal
     *
     * @param \PostBundle\Entity\Post $principal
     * @return Recettes
     */
    public function setPrincipal(\PostBundle\Entity\Post $principal = null)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getPrincipal()
    {
        return $this->principal;
    }

    /**
     * Set patisserie
     *
     * @param \PostBundle\Entity\Post $patisserie
     * @return Recettes
     */
    public function setPatisserie(\PostBundle\Entity\Post $patisserie = null)
    {
        $this->patisserie = $patisserie;

        return $this;
    }

    /**
     * Get patisserie
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getPatisserie()
    {
        return $this->patisserie;
    }

    /**
     * Set view
     *
     * @param integer $view
     * @return Recettes
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return integer 
     */
    public function getView()
    {
        return $this->view;
    }
}
