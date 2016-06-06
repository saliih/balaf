<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    public function gerRecords($nb){
        return $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(
            array("enabled"=>true),array('id'=>"DESC"),$nb
        );
    }
    public function topAction()
    {
        $article = $this->gerRecords(5);
        return $this->render('FrontBundle:Block:top1.html.twig', array('article' => $article));
    }
    public function newLeftAction()
    {
        $article = $this->gerRecords(12);
        return $this->render('FrontBundle:Block:newLeft.html.twig', array('article' => $article));
    }
}
