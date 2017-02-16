<?php

namespace FrontBundle\Controller;

use PostBundle\Entity\Views;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class ArticleController extends Controller
{
    public function indexAction($locale, $categoryname, $year, $month, $slug)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->findOneBy(array('alias' => $slug));
        $ip = $request->getClientIp();
        $view = $this->getDoctrine()->getRepository('PostBundle:Views')->findOneBy(array('post'=>$article,'ip'=>$ip));
        $newnb = $article->getNbview() + 1;
        $article->setNbview($newnb);
        $em->persist($article);
        if($view==null) {
            $view = new Views();
            $view->setPost($article);
            $view->setIp($ip);
            $view->setCreatedby($article->getCreatedby());
            $view->setRefer($request->headers->get('referer'));
            $em->persist($view);
        }
        $em->flush();
        $related = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array("category" => $article->getCategory(), 'enabled' => true), array('publieddate' => 'DESC', 'id'=>'DESC'));
        shuffle($related);
        $i = 0;
        $related2 = $related;
        foreach ($related2 as $key => $value) {
            if ($i > 2) unset($related[$key]);
            ++$i;
        }
        return $this->render('FrontBundle:Article:index.html.twig', array('article' => $article, 'related' => $related));
    }
}
