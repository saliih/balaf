<?php

namespace PostBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Views
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="PostBundle\Entity\ViewsRepository")
 */
class Views
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
     * @ORM\Column(name="dv", type="datetime")
     */
    private $dv;
    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="view")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $post;
    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string")
     */
    private $ip;
    /**
     * @var string
     *
     * @ORM\Column(name="refer", type="string", length=255, nullable=true)
     */
    private $refer;
    /**
     * @ORM\ManyToOne(targetEntity="Refer", inversedBy="view")
     * @ORM\JoinColumn(name="refer_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $referLinks;
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     **/
    private $createdby;

    /**
     * Views constructor.
     */
    public function __construct()
    {
        $this->dv = new \DateTime();
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
     * Set dv
     *
     * @param \DateTime $dv
     * @return Views
     */
    public function setDv($dv)
    {
        $this->dv = $dv;

        return $this;
    }

    /**
     * Get dv
     *
     * @return \DateTime 
     */
    public function getDv()
    {
        return $this->dv;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return Views
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getRefer()
    {
        return $this->refer;
    }

    /**
     * @param mixed $refer
     */
    public function setRefer($refer)
    {
        $this->refer = parse_url($refer, PHP_URL_HOST);
    }

    /**
     * Set post
     *
     * @param \PostBundle\Entity\Post $post
     * @return Views
     */
    public function setPost(\PostBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \PostBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set referLinks
     *
     * @param \PostBundle\Entity\Refer $referLinks
     * @return Views
     */
    public function setReferLinks(\PostBundle\Entity\Refer $referLinks = null)
    {
        $this->referLinks = $referLinks;

        return $this;
    }

    /**
     * Get referLinks
     *
     * @return \PostBundle\Entity\Refer 
     */
    public function getReferLinks()
    {
        return $this->referLinks;
    }

    /**
     * Set createdby
     *
     * @param \Application\Sonata\UserBundle\Entity\User $createdby
     * @return Views
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
}
