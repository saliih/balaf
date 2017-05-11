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

class ShortBlockService extends BaseBlockService
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
            'template' => 'PostBundle:Block:short1.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $views = $this->em->getRepository('PostBundle:Views')->findMonth();
        $array = array();
        $total = 0;
        $final = 0;
        foreach ($views as $view){
            if(!isset($array[$view->getDv()->format('dm')][$view->getIp()])) {
                $array[$view->getDv()->format('dm')][$view->getIp()] = 0;
                $total++;
            }
            $array[$view->getDv()->format('dm')][$view->getIp()]++;
        }
        $array2 = array();
        foreach ($array as $date=>$listIp){
            $count = 0;
            foreach ($listIp as $key=>$ipcount){
                $count += $ipcount;
            }
            $array2[$date] = $count / count($ipcount);
        }
        if(count($array2)>0) {
            $all = 0;
            foreach ($array2 as $value) {
                $all += $value;
            }
            $final = $all / count($array2);
        }
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'title' => "Alexa Rate",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}