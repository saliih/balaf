<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecettesController extends Controller
{
    public function indexAction()
    {
        $dt = new \DateTime();
        $recette = $this->getDoctrine()->getRepository("PostBundle:Recettes")->findOneBy(array('datepub'=>$dt));
        return $this->render('FrontBundle:Recettes:index.html.twig', array("recette"=>$recette));
    }
}
