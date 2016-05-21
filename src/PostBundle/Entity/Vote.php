<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 21/05/16
 * Time: 11:48
 */

namespace PostBundle\Entity;

use DCS\RatingBundle\Entity\Vote as BaseVote;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Vote extends BaseVote
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Rating", inversedBy="votes")
     * @ORM\JoinColumn(name="rating_id", referencedColumnName="id")
     */
    protected $rating;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     */
    protected $voter;
}