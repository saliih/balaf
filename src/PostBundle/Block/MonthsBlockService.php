<?php

/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 30/09/16
 * Time: 11:00
 */
namespace PostBundle\Block;

use PostBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\AdminBundle\Form\FormMapper;
#use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService as BaseBlockService;
use Sonata\BlockBundle\Util\OptionsResolver;

class MonthsBlockService extends BaseBlockService
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
            'template' => 'PostBundle:Block:month.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $posts = $this->em->getRepository('PostBundle:Post')->findAll();
        $final = array();
        foreach ($posts as $post) {
            $index = $post->getPublieddate()->format('Y-m');
            if (!isset($final[$post->getCreatedby()->getUsername()][$index]))
                $final[$post->getCreatedby()->getUsername()][$index] = 0;
            $final[$post->getCreatedby()->getUsername()][$index]++;
        }
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'title' => "Article par mois",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}