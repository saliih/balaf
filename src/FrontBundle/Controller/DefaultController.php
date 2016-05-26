<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FrontBundle:Default:index.html.twig', array());
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
        $newsbar  = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array('enabled'=>true),array("id"=>"DESC"),3);
        return $this->render('FrontBundle:Default:header.html.twig', array(
            "category" => $category,
            "newsbar" => $newsbar,
        ));
    }

    public function footerAction()
    {
        return $this->render('FrontBundle:Default:footer.html.twig', array());
    }

}
