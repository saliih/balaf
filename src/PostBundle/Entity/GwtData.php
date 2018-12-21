<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PostBundle\Model\Seo as Seo;
/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GwtData
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
     * @var \Date
     *
     * @ORM\Column(name="month", type="date",nullable=false)
     */
    private $month;

    /**
     * @var integer
     *
     * @ORM\Column(name="clics", type="integer")
     */
    private $clics;

    /**
     * @var integer
     *
     * @ORM\Column(name="impression", type="integer")
     */
    private $impression;

    /**
     * @ORM\ManyToOne(targetEntity="PostBundle\Entity\GwtRequettes", inversedBy="gwtData")
     * @ORM\JoinColumn(name="req_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $gwtRequette;
    /**
     * @var float
     *
     * @ORM\Column(name="position", type="float")
     */
    private $position;


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
     * @return \Date
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param \Date $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return int
     */
    public function getClics()
    {
        return $this->clics;
    }

    /**
     * @param int $clics
     */
    public function setClics($clics)
    {
        $this->clics = $clics;
    }

    /**
     * @return int
     */
    public function getImpression()
    {
        return $this->impression;
    }

    /**
     * @param int $impression
     */
    public function setImpression($impression)
    {
        $this->impression = $impression;
    }

    /**
     * @return mixed
     */
    public function getGwtRequette()
    {
        return $this->gwtRequette;
    }

    /**
     * @param mixed $gwtRequette
     */
    public function setGwtRequette($gwtRequette)
    {
        $this->gwtRequette = $gwtRequette;
    }

    /**
     * @return float
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param float $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

}
