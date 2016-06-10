<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
    protected $catid = array();

    public function gerRecords($nb)
    {
        return $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(
            array("enabled" => true), array('id' => "DESC"), $nb
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

    public function cuisineAction()
    {
        $this->catid[] = 1;
        $category = $this->getDoctrine()->getRepository("PostBundle:Category")->find(1);
        //$this->recurcive($category);
        $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array("enabled" => true, 'category' => $category), array('id' => "DESC"), 4);
        return $this->render('FrontBundle:Block:cuisine.html.twig', array('article' => $article));
    }

    public function mamanAction()
    {
        $this->catid[] = 4;
        $category = $this->getDoctrine()->getRepository("PostBundle:Category")->find(4);
        //$this->recurcive($category);
        $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array("enabled" => true, 'category' => $category), array('id' => "DESC"), 5);
        return $this->render('FrontBundle:Block:maman.html.twig', array('article' => $article));
    }

    public function centerAction($id)
    {
        $this->catid[] = $id;
        $category = $this->getDoctrine()->getRepository("PostBundle:Category")->find($id);
        //$this->recurcive($category);
        $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array("enabled" => true, 'category' => $category), array('id' => "DESC"), 6);
        return $this->render('FrontBundle:Block:center.html.twig', array(
            'article' => $article,
            'category' => $category
        ));
    }

    public function tabAction($id)
    {

        $order = ($id == 1) ? array('nbview' => 'DESC') : array('id' => 'DESC');

        $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array("enabled" => true), $order, 5);
        return $this->render('FrontBundle:Block:tab.html.twig', array(
            'article' => $article
        ));
    }

    public function visitedAction()
    {
        $request = $this->get('request');
        $session = $request->getSession();
        $pageView = $session->get('pageView');
        if(!is_array($pageView))$pageView = array();
        $pageView = array_reverse($pageView);
        $article = array();
        if(count($pageView)>0) {
            $i = 0;
            foreach ($pageView as $value) {
                if ($i < 4) $tab[] = $value;
                ++$i;
            }

            $article = $this->getDoctrine()->getRepository("PostBundle:Post")->findBy(array("enabled" => true, 'id' => $tab));
        }
		return $this->render('FrontBundle:Block:vistied.html.twig', array(
            'article' => $article
        ));
	}
    public function categoriesAction(){$nb = 4;
        $categories = $this->getDoctrine()->getRepository("PostBundle:Category")->findAll();
        $tab = array();
        foreach($categories as $value){
            $tab[$value->getNbPost()] = $value;
        }
        ksort($tab);
        $tab = array_reverse($tab);
        $i = 0;
        foreach($tab as $key=>$value){
            if($i >$nb){
                unset($tab[$key]);
            }
        }
        return $this->render('FrontBundle:Block:categories.html.twig', array(
            'categories' => $tab
        ));
    }
    /*public function recurcive($parent){
        foreach($parent->getChildren() as $child){
            $this->catid[] = $child->getId();
            if(count(child->getChildren()) > 0){
                $this->recurcive($child);
            }
        }
    }*/
}
