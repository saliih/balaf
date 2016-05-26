<?php
/**
 * Created by PhpStorm.
 * User: salah
 * Date: 22/03/2016
 * Time: 16:45
 */

namespace FrontBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

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
            'treenav' => new \Twig_Filter_Method($this, 'treenav')
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
    public function treenav($cat){
        $html = "";
        if($cat->getParent()!=null){
            $html .= '<li><a href="#">'.$cat->getParent()->getTitle().'</a> <span class="divider">/</span></li>';
        }
        return $html .=' <li class="active">'.$cat->getTitle().'</li>';
    }
    public function getName()
    {
        return 'app_extension';
    }
}