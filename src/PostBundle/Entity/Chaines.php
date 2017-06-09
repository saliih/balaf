<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chaines
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Chaines
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="chaineId", type="string", length=255, nullable=true)
     */
    private $chaineId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="act", type="boolean")
     */
    private $act;

    public function __toString()
    {
        return (string)$this->name;
    }

    public function __construct()
    {
        $this->act=false;
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
     * @return Chaines
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
     * Set url
     *
     * @param string $url
     * @return Chaines
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set chaineId
     *
     * @param string $chaineId
     * @return Chaines
     */
    public function setChaineId($chaineId)
    {
        $this->chaineId = $chaineId;

        return $this;
    }

    /**
     * Get chaineId
     *
     * @return string 
     */
    public function getChaineId()
    {
        return $this->chaineId;
    }

    /**
     * Set act
     *
     * @param boolean $act
     * @return Chaines
     */
    public function setAct($act)
    {
        $this->act = $act;

        return $this;
    }

    /**
     * Get act
     *
     * @return boolean 
     */
    public function getAct()
    {
        return $this->act;
    }
}
