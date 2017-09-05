<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * aa
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class aa
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
     * @var array
     *
     * @ORM\Column(name="mailinglist", type="array")
     */
    private $mailinglist;


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
     * Set mailinglist
     *
     * @param array $mailinglist
     * @return aa
     */
    public function setMailinglist($mailinglist)
    {
        $this->mailinglist = $mailinglist;

        return $this;
    }

    /**
     * Get mailinglist
     *
     * @return array 
     */
    public function getMailinglist()
    {
        return $this->mailinglist;
    }
}
