<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlockController extends Controller
{
	protected $catid = array();
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
	public function cuisineAction(){
		$this->catid[] = 1;
		$category = $this->getDoctrine()->getRepository("PostBundle:Category")->find(1);
		//$this->recurcive($category);
		$article = $this->getDoctrine()->getRepository("PostBundle:Post")->findbycat($this->catid);
		return $this->render('FrontBundle:Block:cuisine.html.twig', array('article' => $article));
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
