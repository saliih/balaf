<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function topAction()
    {
        $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(
            array("enabled"=>true),array('id'=>"DESC")
        );
        return $this->render('FrontBundle:Block:top1.html.twig', array('article' => $article));
    }
}
