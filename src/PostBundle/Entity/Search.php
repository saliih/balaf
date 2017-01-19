<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Search
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Search
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
     * @ORM\Column(name="search", type="string", length=255)
     */
    private $search;


    /**
     * @var integer
     *
     * @ORM\Column(name="nbresult", type="integer", length=255)
     */
    private $result;

    /**
     * @var boolean
     *
     * @ORM\Column(name="act", type="boolean",nullable=true)
     */
    private $act;
    public function __construct()
    {
        $this->act = false;
    }
    public function __toString()
    {
        return $this->search;
    }

    /**
     * @return boolean
     */
    public function isAct()
    {
        return $this->act;
    }

    /**
     * @param boolean $act
     */
    public function setAct($act)
    {
        $this->act = $act;
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
     * Set search
     *
     * @param string $search
     * @return Search
     */
    public function setSearch($search)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get search
     *
     * @return string 
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }
}
