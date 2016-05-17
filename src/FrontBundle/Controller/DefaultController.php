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
        return $this->render('FrontBundle:Default:hearder.html.twig', array("category" => $category));
    }

    public function footerAction()
    {
        return $this->render('FrontBundle:Default:footer.html.twig', array());
    }

}
