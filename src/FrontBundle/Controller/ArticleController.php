<?php

namespace FrontBundle\Controller;

use PostBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use PostBundle\Services\MobileDetect;

class ArticleController extends Controller
{
    public function indexAction($locale, $categoryname, $year, $month, $slug)
    {
        //ptisseries
        $params = [
            "locale" => $locale,
            "categoryname" => $categoryname,
            "year" => $year,
            "month" => $month,
            "slug" => $slug,
        ];
        if($categoryname === "ptes"){
            $params["categoryname"] = "pates";
            $url = $this->generateUrl("front_article",$params);
            return $this->redirect($url, 301);
        }elseif ($slug === "cannelloni-aux-pinards-et-ricotte") {
            $params["slug"] = "cannelloni-aux-epinards-et-ricotte";
            $url = $this->generateUrl("front_article", $params);
            return $this->redirect($url, 301);
        }elseif ($slug === "harissa") {
            $params["slug"] = "harissa-hloua";
            $url = $this->generateUrl("front_article", $params);
            return $this->redirect($url, 301);
        }elseif ($slug === "pt-au-thon-tunisien"){
            $params["slug"] = "pate-au-thon-tunisien";
            $url = $this->generateUrl("front_article",$params);
            return $this->redirect($url, 301);
        }elseif ($slug === "crme-au-beurre"){
            $params["slug"] = "creme-au-beurre";
            $url = $this->generateUrl("front_article",$params);
            return $this->redirect($url, 301);
        }elseif ($categoryname === "ptisseries"){
            $params["categoryname"] = "patisseries";
            $url = $this->generateUrl("front_article",$params);
            return $this->redirect($url, 301);
        }elseif ($categoryname === "entrs"){
            $params["categoryname"] = "entrees";
            $url = $this->generateUrl("front_article",$params);
            return $this->redirect($url, 301);
        }elseif ($categoryname === "cuisine"){
            $article = $this->getDoctrine()->getRepository('PostBundle:Post')->findOneBy(array('alias' => $slug));
            /** @var Category $category */
            $category = $article->getCategory();
            $params["categoryname"] = $category->getSlug();
            $url = $this->generateUrl("front_article",$params);
            return $this->redirect($url, 301);
        }
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->findOneBy(array('alias' => $slug));
        $ip = $request->getClientIp();
        if (!in_array($ip,array("197.3.10.74")) && $article->getEnabled()) {
            $newnb = (integer)$article->getNbview() + 1;
            $article->setNbview($newnb);
            $em->persist($article);
            $em->flush();
        }
        $related = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array("category" => $article->getCategory(), 'enabled' => true), array('publieddate' => 'DESC', 'id' => 'DESC'));
        shuffle($related);
        $i = 0;
        $related2 = $related;
        foreach ($related2 as $key => $value) {
            if ($i > 2) unset($related[$key]);
            ++$i;
        }
        $template = 'FrontBundle:Article:index.html.twig';
        if(in_array($article->getCategory()->getId(),array(3,4,5,6))){
            $template = 'FrontBundle:Article:notrecipe.html.twig';
        }elseif ($article->getIngredients()->count()){
            $template = 'FrontBundle:Article:ingredient.html.twig';
        }
        return $this->render( $template, array('article' => $article, 'related' => $related));
    }

    public function toPrintAction($id)
    {
        $request = $this->get('request');
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->find($id);
        return $this->render('FrontBundle:Article:print.html.twig', array('article' => $article, 'related' => array()));
    }

}
