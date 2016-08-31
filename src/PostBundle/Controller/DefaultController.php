<?php

namespace PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PostBundle:Default:index.html.twig', array('name' => $name));
    }
    public function linkpostAction(){
        $posts = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array('enabled'=>true));
        $tab = array();
        foreach($posts as $post){
            $tab[] = array(
                "title"=>$post->getTitle(),
                "value"=>$this->generateUrl('front_article',array(
                    "locale"=>"fr",
                    "categoryname"=>$post->getCategory()->getSlug(),
                    "year"=> $post->getCreated()->format("Y"),
                    "month"=> $post->getCreated()->format("m"),
                    "slug"=>$post->getAlias()
                ))
            );
        }
        return new JsonResponse($tab);
    }
}
