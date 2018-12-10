<?php

namespace FrontBundle\Controller;

use PostBundle\Entity\Category;
use PostBundle\Entity\Refer;
use PostBundle\Entity\Views;
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
        if (!in_array($ip,array('45.58.117.232', "197.3.10.74"))) {
            $newnb = count($article->getView()) + 1;
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
        return $this->render('FrontBundle:Article:index.html.twig', array('article' => $article, 'related' => $related));
    }

    public function toPrintAction($id)
    {
        $request = $this->get('request');
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->find($id);
        return $this->render('FrontBundle:Article:print.html.twig', array('article' => $article, 'related' => array()));
    }

}
