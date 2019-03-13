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
    private $tools;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->tools = $this->container->get('Tools.utils');
    }

    public function getFilters()
    {
        return array(
            'shortdesc' => new \Twig_Filter_Method($this, 'shortdesc'),
            'expire' => new \Twig_Filter_Method($this, 'expireFilter'),
            'adsense' => new \Twig_Filter_Method($this, 'adsenseFilter'),
            'pbalise' => new \Twig_Filter_Method($this, 'pbaliseFilter'),
            'sitemap' => new \Twig_Filter_Method($this, 'sitemap')
        );
    }
    public function adsenseFilter($str){
        $html = '<br /><ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-6877324570550574"
        data-ad-slot="9868401699"
        data-ad-format="auto"></ins>
   <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
   </script><h2>';
        $str = str_replace("<h2>", $html, $str);
        $str = str_replace("<li>",'<li itemprop="recipeIngredient">', $str);

        return $str;
    }
    public function pbaliseFilter($str){
        $str = str_replace("<p>", '<p itemprop="recipeInstructions">', $str);
        return $str;
    }
    public function expireFilter($str){
        $dt = new \DateTime();
        $dt->modify("+ 1 month");
        return $dt->format("D, d  M Y");
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
    public function sitemap($url){
        $test = $this->container->get('doctrine')->getRepository('PostBundle:Sitemap')->findBy(array('loc'=>$url));
        $em = $this->container->get('doctrine')->getEntityManager();
        if($test == null){
            $sitemaps = new Sitemap();
            $sitemaps->setLoc($url);
            //echo "<pre>";print_r($sitemaps);exit;
            $em->persist($sitemaps);
            $em->flush();
        }
    }
    public function getName()
    {
        return 'app_extension';
    }
}