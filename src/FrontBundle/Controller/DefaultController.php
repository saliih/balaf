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
        return $this->render('FrontBundle:Default:hearder.html.twig', array());
    }
    public function footerAction()
    {
        return $this->render('FrontBundle:Default:footer.html.twig', array());
    }

}
