<?php
/**
 * Created by PhpStorm.
 * User: salah
 * Date: 22/03/2016
 * Time: 16:45
 */

namespace FrontBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use PostBundle\Entity\Sitemap;
class AppExtension extends \Twig_Extension
{
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            'shortdesc' => new \Twig_Filter_Method($this, 'shortdesc'),
            'sitemaps' => new \Twig_Filter_Method($this, 'sitemap')
        );
    }

    public function shortdesc($str,$size = 500){
        $text = strip_tags($str);
        if(strlen($text)>=$size){
            $text = substr($text,0,$size);
            $espace = strrpos($text," ");
            $text = substr($text,0,$espace);
        }
        return $text;
    }
    public function sitemaps($url){
        $test = $this->container->getDoctrine()->getRepository('PostBundle:Sitemap')->findBy(array('loc'=>$url));
        $em = $this->container->get('doctrine')->getEntityManager();
        if($test == null){
            $sitemaps = new Sitemap();
            $sitemaps->setLoc($url);
            echo "<pre>";print_r($sitemaps);exit;
            $em->persist($sitemaps);
            $em->flush();
        }
    }
    public function getName()
    {
        return 'app_extension';
    }
}