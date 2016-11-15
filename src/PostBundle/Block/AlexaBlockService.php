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

class AlexaBlockService extends BaseBlockService
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
            'title' => 'Article par mois',
            'template' => 'PostBundle:Block:alexa.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $rates = $this->em->getRepository('PostBundle:Alexa')->findAll();
        $final = array();
        foreach ($rates as $rate) {
            $index = $rate->getDcr()->format('Ymd');
            if (!isset($final[$index]))
                $final[$index] = 0;
            $final[$index] = $rate->getValue();
        }
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'title' => "Alexa Rate",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}