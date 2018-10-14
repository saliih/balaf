<?php

namespace FrontBundle\Controller;

use PostBundle\Entity\Search;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function ramadanAction(Request $request,$locale,$year){
        $posts = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array('ramadan2017' => true, 'enabled' => true), array('publieddate' => 'DESC', 'id' => 'DESC'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        return $this->render('FrontBundle:Category:ramadan.html.twig', array( 'posts' => $pagination));
    }

    public function tagsAction(Request $request,$locale,$name){
        $tag = $this->getDoctrine()->getRepository("PostBundle:Tags")->findOneBy([['slug' => $name]]);
        $posts =  $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(['tags'=> $tag], ['publieddate' => 'DESC', 'id' => 'DESC']);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        return $this->render('FrontBundle:Category:tags.html.twig', array('tags' => $tag,  'name' => $name, 'posts' => $pagination));
    }

    public function indexAction($locale, $slug)
    {
        $request = $this->get("request");
        $category = $this->getDoctrine()->getRepository('PostBundle:Category')->findOneBy(array('slug' => $slug, 'locale' => $locale));
        if ($category == null) return $this->redirect($this->generateUrl('front_homepage'));
        $posts = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array('category' => $category, 'enabled' => true), array('publieddate' => 'DESC', 'id' => 'DESC'));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        return $this->render('FrontBundle:Category:index.html.twig', array("category" => $category, 'posts' => $pagination));
    }

    public function searchAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');
        $search = $request->query->get('s');
        $page = $request->query->get('page');
        // history search
        $posts = $this->getDoctrine()->getRepository('PostBundle:Post')->search($search);
        if (in_array($page, array('1', '', 0))) {
            $findstr = new Search();
            $findstr->setResult(count($posts));
            $findstr->setSearch($search);
            $em->persist($findstr);
            $em->flush();
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            12/*limit per page*/
        );
        return $this->render('FrontBundle:Category:search.html.twig', array("search" => $search, 'posts' => $pagination));

    }
}
