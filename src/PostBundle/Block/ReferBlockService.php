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

class ReferBlockService extends BaseBlockService
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
        return 'Refer';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url' => false,
            'title' => 'Comparatif',
            'template' => 'PostBundle:Block:refer.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $views = $this->em->getRepository('PostBundle:Views')->findBy(array(),array('id'=>'DESC'),2000);
        $final = array();
        foreach ($views as $view) {
            if($view->getRefer()!=""){
                if(!isset($final[$view->getRefer()])) $final[$view->getRefer()] =0;
                $final[$view->getRefer()] ++;
            }

        }
        usort($final);

        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'title' => "Site Refer",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}