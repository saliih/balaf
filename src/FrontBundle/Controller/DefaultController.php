<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function ad300Action(){
        return $this->render('FrontBundle:Default:ad300.html.twig', array());
    }
    public function ad728Action($header=false){
        return $this->render('FrontBundle:Default:ad728.html.twig', array("header"=>$header));
    }
    public function indexAction()
    {
        // Nos séléction
        $selection  = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array("enabled"=>true),array('publieddate'=>'DESC', 'id'=>'DESC'));
        $nbselection = count($selection);
        $tab = array();
        for($i=0;$i<20;$i++){
            $index = rand(0,$nbselection);
            $tab[$index] = $index;
        }
        $selection2 = array();
        foreach($selection as $key=>$value){
            if(in_array($key,$tab)){
                $selection2[] = $value;
            }
        }

        return $this->render('FrontBundle:Default:index.html.twig', array("selection"=>$selection2));
    }

    public function sidebarAction()
    {
        return $this->render('FrontBundle:Default:sidebar.html.twig', array());
    }

    public function headerAction()
    {

        $locale = $this->get('request')->getLocale();


        $category = $this->getDoctrine()->getRepository('PostBundle:Category')->findBy(array(
            'parent' => null,
            'locale'=>$locale
        ));
        $newsbar  = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array('enabled'=>true),array('publieddate'=>'DESC', 'id'=>'DESC'),3);
        return $this->render('FrontBundle:Default:header.html.twig', array(
            "category" => $category,
            "newsbar" => $newsbar,
        ));
    }

    public function footerAction()
    {
        return $this->render('FrontBundle:Default:footer.html.twig', array());
    }
    public function sitemapsAction(){
        $categories  = $this->getDoctrine()->getRepository('PostBundle:Category')->findAll();
        $nbPosts = array();
        foreach ($categories as $category){
            $nbPosts[$category->getId()] = ceil(count($category->getPosts())/12);
        }
        $posts  = $this->getDoctrine()->getRepository('PostBundle:Post')->findAll();
        $response = new Response();
        $response->headers->set('Content-Type', 'xml');
        return $this->render('FrontBundle:Default:sitemaps.xml.twig', array(
            'categories'=>$categories,
            'articles'=>$posts,
            'nbPosts'=>$nbPosts
        ),$response);
    }
    public function rssAction(){
        $posts  = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array('enabled'=>true),array('publieddate'=>'DESC', 'id'=>'DESC'),10);
        $response = new Response();
        $response->headers->set('Content-Type', 'xml');
        return $this->render('FrontBundle:Default:rss.xml.twig', array(
            'articles'=>$posts
        ),$response);
    }


}
