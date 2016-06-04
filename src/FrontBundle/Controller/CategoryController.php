<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction($locale,$slug)
    {
        $request = $this->get("request");
        $category = $this->getDoctrine()->getRepository('PostBundle:Category')->findOneBy(array('slug'=>$slug,'locale'=>$locale));
        if($category == null)return $this->redirect($this->generateUrl('front_homepage'));
        $posts = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array('category'=>$category),array('id'=>'DESC'));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('FrontBundle:Category:index.html.twig', array("category"=>$category,'posts' => $pagination));
    }
}
