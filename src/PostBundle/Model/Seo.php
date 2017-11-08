<?php
/**
 * Created by PhpStorm.
 * User: salah
 * Date: 07/09/2017
 * Time: 15:01
 */

namespace PostBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

class Seo
{
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="title_seo", type="string",length=160, nullable=true)
     */
    protected $titleSeo;
    /**
     * @var string
     *
     * @Gedmo\Translatable
     * @ORM\Column(name="description_seo", type="string",length=255, nullable=true)
     */
    protected $descriptionSeo;

    /**
     * @return string
     */
    public function getTitleSeo()
    {
        return $this->titleSeo;
    }

    /**
     * @param string $titleSeo
     */
    public function setTitleSeo($titleSeo)
    {
        $this->titleSeo = $titleSeo;
    }

    /**
     * @return string
     */
    public function getDescriptionSeo()
    {
        return $this->descriptionSeo;
    }

    /**
     * @param string $descriptionSeo
     */
    public function setDescriptionSeo($descriptionSeo)
    {
        $this->descriptionSeo = $descriptionSeo;
    }

}