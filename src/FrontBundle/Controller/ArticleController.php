<?php

namespace FrontBundle\Controller;

use PostBundle\Entity\Refer;
use PostBundle\Entity\Views;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use PostBundle\Services\MobileDetect;

class ArticleController extends Controller
{
    public function indexAction($locale, $categoryname, $year, $month, $slug)
    {
        $request = $this->get('request');
        $em = $this->getDoctrine()->getEntityManager();
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->findOneBy(array('alias' => $slug));
        $ip = $request->getClientIp();
        if ($ip != "197.3.10.74") {
            $view = $this->getDoctrine()->getRepository('PostBundle:Views')->findOneBy(array(
                'post' => $article,
                'ip' => $ip,
                'dv' => new \DateTime()
            ));
            $newnb = count($article->getView()) + 1;

            $refer = $request->headers->get('referer');
            $refer = parse_url($refer, PHP_URL_HOST);
            if ($view === null && $refer != "" && $article->getEnabled()) {
                $referLink = $this->getDoctrine()->getRepository('PostBundle:Refer')->findOneBy(array('title'=>$refer));
                if ($referLink === null) {
                    $referLink = new Refer();
                    $referLink->setTitle($refer);
                    $em->persist($referLink);
                    $em->flush();
                }
                $view = new Views();
                $view->setPost($article);
                $view->setIp($ip);
                $view->setCreatedby($article->getCreatedby());
                $view->setRefer($refer);
                $view->setReferLinks($referLink);
                $detect = new MobileDetect();
                $view->isMobile($detect->isMobile() && $detect->isTablet());
                $em->persist($view);
                $article->setNbview($newnb);
                $em->persist($article);
            }
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
        $em = $this->getDoctrine()->getEntityManager();
        $article = $this->getDoctrine()->getRepository('PostBundle:Post')->find($id);
        $ip = $request->getClientIp();

        return $this->render('FrontBundle:Article:print.html.twig', array('article' => $article, 'related' => array()));
    }

}
