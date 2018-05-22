<?php

/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 20/06/16
 * Time: 16:19
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

class ShareBlockService extends BaseBlockService
{
    protected $em;
    protected $template;
    protected $type;
    protected $container;

    public function __construct($type, $templating, $container)
    {
        $this->type = $type;
        $this->templating = $templating;
        $this->container = $container;
        $this->em = $container->get('doctrine');
    }

    public function getName()
    {
        return 'Posts';
    }

    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'url' => false,
            'title' => 'Status items',
            'template' => 'PostBundle:Block:share.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $posts = $this->em->getRepository('PostBundle:Post')->findBy(array( 'ramadan2017'=>true,'twitter' => false, 'enabled' => true), array('id' => 'DESC'),3);
        $postsnonactive = $this->em->getRepository('PostBundle:Post')->findBy(array('ramadan2017'=>true,'twitter' => false, 'enabled' => true));

        return $this->renderResponse($blockContext->getTemplate(), array(
            'posts' => $posts,
            'rest' => count($postsnonactive),
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}