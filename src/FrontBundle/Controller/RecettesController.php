<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecettesController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dt = new \DateTime();
        //$recette = $this->getDoctrine()->getRepository("PostBundle:Recettes")->findOneBy(array('datepub'=>$dt));
        $recette = $this->getDoctrine()->getRepository("PostBundle:Recettes")->find(362);

        $recette->setView($recette->getView()+1);
        $em->persist($recette);
        $em->flush();
        return $this->render('FrontBundle:Recettes:index.html.twig', array("recette"=>$recette));
    }
}
