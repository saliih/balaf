<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class ArticleController extends Controller
{
    public function indexAction($locale,$categoryname,$year,$month,$slug)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        $session = $request->getSession();
        $pageView = $session->get('pageView');
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->findOneBy(array('alias'=>$slug));
        //if(!isset($pageView[$article->getId()])){
          //  $pageView[$article->getId()] = $article->getNbview();
            $newnb = $article->getNbview() + 1;
            $article->setNbview($newnb);
            $em->persist($article);
            $em->flush();
            //$session->set('pageView',$pageView);
        //}
        $related = array();
      $related = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array("category"=>$article->getCategory(),'enabled'=>true),array());
        shuffle($related);
        $i = 0;
        $related2 = $related;
        foreach ($related2 as $key=>$value){
            if($i>2)unset($related[$key]);
            ++$i;
        }
        return $this->render('FrontBundle:Article:index.html.twig', array('article' => $article,'related'=>$related));
    }
}
