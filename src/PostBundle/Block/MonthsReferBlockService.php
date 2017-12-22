<?php

/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 30/09/16
 * Time: 11:00
 */
namespace PostBundle\Block;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\AdminBundle\Form\FormMapper;
#use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService as BaseBlockService;
use Sonata\BlockBundle\Util\OptionsResolver;

class MonthsReferBlockService extends BaseBlockService
{
    protected $em;
    protected $template;
    protected $type;

    public function __construct($type, $templating, $em)
    {
        $this->type = $type;
        $this->templating = $templating;
        $this->em = $em;
    }

    public function getName()
    {
        return 'Table';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url' => false,
            'title' => 'Site referant par mois',
            'template' => 'PostBundle:Block:monthrefer.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $views = $this->em->getRepository('PostBundle:Views')->findMonth();
        $data = array();
        $count = count($views);
        foreach ($views as $view){
            $url = $view->getRefer();

            if(!(strpos($url, "google") === false)){
                $url = "Google";
            }else if(!(strpos($url, "facebook") === false)){
                $url = "Facebook";
            }else if(!(strpos($url, "scoop") === false)){
                $url = "Scoop";
            }else if(!(strpos($url, "yahoo") === false)){
                $url = "Yahoo";
            }else if(!(strpos($url, "bing") === false)){
                $url = "Bing";
            }else if(!(strpos($url, "t.co") === false)){
                $url = "Twitter";
            }else if(!(strpos($url, "twitter.com") === false)){
                $url = "Twitter";
            }else if(!(strpos($url, "flipboard") === false)){
                $url = "Flipboard";
            }else if(!(strpos($url, "pinterest") === false)){
                $url = "Pinterest";
            }else if(!(strpos($url, "pinterest") === false)){
                $url = "Pinterest";
            }
            else
                continue;

            if (!isset($data[$url])) {
                $data[$url] = array($url, 0);
            }
            $data[$url][1]++;
        }
        foreach ($data as $key=>$value){
            $data[$key][1] = $value[1] * 100 / $count;
            $data[$key]['color'] = $this->stringToColorCode($key);//.rand(84,4898)
        }//echo "<pre>"; print_r($data);exit;
        foreach ($data as $key=>$value){
            if($value[1] <= 3){
                if(!isset($data['other'])) {
                    $data["other"] = array("other",0 ,"color"=>$this->stringToColorCode("other"));//.rand(84,4898)
                }
                $data['other'][1] += $value[1];
                unset($data[$key]);

            }
        }

        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $data,
            'title' => "Site referant par mois",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
    private function stringToColorCode($str) {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return $code;
    }
}