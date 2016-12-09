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
    public function toolbarAction(){
        $posts = $this->getDoctrine()->getRepository('PostBundle:Post')->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $search = $this->getDoctrine()->getRepository('PostBundle:Search')->findAll();
        $view = 0;
        $myview = 0;
        $mypost = 0;
        foreach ($posts as $post) {
            if ($post->getCreatedby()->getId() == $user->getId()) {
                $mypost++;
                $myview += $post->getNbview();
            }
            $view += $post->getNbview();
        }
        return $this->render('PostBundle:Default:toolbar.html.twig', array(
            'nbposts' => count($posts),
            'view' => $view,
            'mypost' => $mypost,
            'myview' => $myview,
            'search' => count($search)
        ));

    }
}
