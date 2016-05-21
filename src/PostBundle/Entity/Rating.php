<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 21/05/16
 * Time: 11:48
 */

namespace PostBundle\Entity;
use DCS\RatingBundle\Entity\Rating as BaseRating;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */

class Rating extends BaseRating
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="rating")
     */
    protected $votes;
}