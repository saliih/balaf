<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GwtRequettes
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
     * @ORM\OneToMany(targetEntity="PostBundle\Entity\GwtData", mappedBy="gwtRequette", cascade={"persist"})
     */
    private $gwtData;

    public function __toString()
    {
        return (string)$this->name;
    }
    public function __construct()
    {
        $this->gwtData = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGwtData()
    {
        return $this->gwtData;
    }

    /**
     * @param mixed $gwtData
     */
    public function setGwtData($gwtData)
    {
        $this->gwtData = $gwtData;
    }
}
