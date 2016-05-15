<?php

namespace PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PostBundle:Default:index.html.twig', array('name' => $name));
    }
}
