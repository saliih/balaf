<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    public function indexAction($locale,$categoryname,$year,$month,$slug)
    {
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->findOneBy(array('alias'=>$slug));
        return $this->render('FrontBundle:Article:index.html.twig', array('article' => $article));
    }
}
