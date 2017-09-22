<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PostBundle:Default:index.html.twig', array('name' => $name));
    }

    public function linkpostAction()
    {
        $posts = $this->getDoctrine()->getRepository('PostBundle:Post')->findBy(array('enabled' => true));
        $tab = array();
        foreach ($posts as $post) {
            $tab[] = array(
                "title" => $post->getTitle(),
                "value" => $this->generateUrl('front_article', array(
                    "locale" => "fr",
                    "categoryname" => $post->getCategory()->getSlug(),
                    "year" => $post->getCreated()->format("Y"),
                    "month" => $post->getCreated()->format("m"),
                    "slug" => $post->getAlias()
                ))
            );
        }
        return new JsonResponse($tab);
    }

    public function toolbarAction()
    {
        $posts = $this->getDoctrine()->getRepository('PostBundle:Post')->findAll();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $search = $this->getDoctrine()->getRepository('PostBundle:Search')->findBy(array('act' => false));
        $tasks = $this->getDoctrine()->getRepository('PostBundle:Tasks')->findBy(array('act' => false));

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
            'tasks' => count($tasks),
            'myview' => $myview,
            'search' => count($search)
        ));

    }

    public function youtubeAction()
    {
        $request = $this->get('request');
        $url = $request->request->get('url');
        $tab = explode('=', $url);
        $id = $tab[1];
        $html = 'https://www.googleapis.com/youtube/v3/videos?id=' . $id . '&key=AIzaSyBGseWi-G-NxC1wO0R4UtTEg0HmSPXSJlI&part=snippet';
        $response = file_get_contents($html);
        $decoded = json_decode($response, true);
        $data = $decoded['items'][0]['snippet'];
        $data['publishedAt'] = $this->convertdate($data['publishedAt']);
        return new JsonResponse($data);
    }

    public function pieChartsAction(Post $post){
        $data = array();
        foreach ($post->getView() as $item){
            $url = $item->getRefer();
           /* $host = parse_url($url, PHP_URL_HOST);print_r($host);
			 $name = $parse['host'];
            if($name == "t.co"){
                $name = "twitter.com";
            }
            if($name == 'tounsia.net')
                continue;*/
            if(!isset($data[$url])){
                $data[$url] = array('label'=>$url,'data'=>0);
            }
            $data[$url]['data']++;
        }
        return new JsonResponse(array_values($data));
    }
 

}
