<?php

/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 30/09/16
 * Time: 11:00
 */

namespace PostBundle\Block;

use PostBundle\Entity\Alexa;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\AdminBundle\Form\FormMapper;
#use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService as BaseBlockService;
use Sonata\BlockBundle\Util\OptionsResolver;

class ShortAlexaBlockService extends BaseBlockService
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
        return 'Short Alexa';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url' => false,
            'template' => 'PostBundle:Block:short2.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $alexas = $this->em->getRepository('PostBundle:Alexa')->findBy(array(),array('dcr'=>"DESC"));
        /** @var Alexa $alexa */
        $total = 0;
        $i = 0;
        foreach ($alexas as $alexa) {
            if($i > 365 )
                break;
            $total += $alexa->getValue();
            ++$i;
        }
        $total = round($total / 365,0);
        return $this->renderResponse($blockContext->getTemplate(), array(
            'total' => $total,
            'title' => "Alexa Average Rate",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}