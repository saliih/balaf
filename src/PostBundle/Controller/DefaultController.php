<?php

namespace PostBundle\Controller;

use PostBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PostBundle:Default:index.html.twig', array('name' => $name));
    }

    public function shareTwitterAction($id){
       $post = $this->getDoctrine()->getRepository('PostBundle:Post')->find($id);
       $service = $this->get('Tools.utils');
       $service->sharePostTwitter($post);
       return new JsonResponse(array("success"=>true));
    }

    public function imageAction($id)
    {
        $post = $this->getDoctrine()->getRepository("PostBundle:Post")->find($id);
        $service = $this->get('tools.utils');
        $url = "https://www.tounsia.net/print/" . $post->getId();
        $filename = $service->generatePDFOrImage(file_get_contents($url), false, "portrait", 700);
        $response = new BinaryFileResponse($filename);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;

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
        $request = $this->get('request_stack');
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

    public function pieChartsAction(Post $post)
    {
        $mobile = array('mobile'=>array('label' => "Mobile", 'data' => 0),'desktop'=>array('label' => "Desktop", 'data' => 0));
        $data = array();
        $count = $post->getView()->count();
        foreach ($post->getView() as $item) {
            $url = $item->getRefer();

            if(!(strpos($url, "google") === false)){
                $url = "google";
            }else if(!(strpos($url, "facebook") === false)){
                $url = "facebook";
            }else if(!(strpos($url, "scoop") === false)){
                $url = "scoop";
            }else if(!(strpos($url, "yahoo") === false)){
                $url = "yahoo";
            }/*else if(!(strpos($url, "tounsia") === false)){
                $url = "tounsia";
            }*/else if(!(strpos($url, "bing") === false)){
                $url = "bing";
            }else if(!(strpos($url, "t.co") === false)){
                $url = "twitter";
            }else if(!(strpos($url, "twitter.com") === false)){
                $url = "twitter";
            }else if(!(strpos($url, "flipboard") === false)){
                $url = "flipboard";
            }else if(!(strpos($url, "pinterest") === false)){
                $url = "pinterest";
            }else if(!(strpos($url, "pinterest") === false)){
                $url = "pinterest";
            }
            else
                continue;

            if (!isset($data[$url])) {
                $data[$url] = array($url, 0);
            }
            $data[$url][1]++;
            if($item->isMobile()){
                $mobile['mobile']['data']++;
            }else{
                $mobile['desktop']['data']++;
            }
        }
        foreach($data as $key=>$value){
            $percent = $value[1] * 100 / $count;
            if($percent <= 5){
                if(!isset($data['other'])) {
                    $data["other"] = array("other",0);
                }
                $data['other'][1] += $value[1];
                unset($data[$key]);

            }
        }
        return new JsonResponse(array("views"=>array_values($data),"mobile"=>array_values($mobile)));
    }

    public function listtoUpdateAction(){
        $posts = $this->getDoctrine()->getRepository('PostBundle:Post')->findAll();
        /**
         * @var integer $key
         * @var Post $post
         */
        foreach ($posts as $key => $post){
            if($post->getIngredients()->count() || in_array($post->getCategory()->getId(), array(3,4,5,6))){
                unset($posts[$key]);
            }
        }
        return $this->render('PostBundle:Default:notingredient.html.twig', array('posts' => $posts));
    }

}
