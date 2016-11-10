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

class PostsBlockService extends BaseBlockService
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
            'template' => 'PostBundle:Block:Posts.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $posts = $this->em->getRepository('PostBundle:Post')->findBy(array('enabled' => true));
        $user = $this->container->get('security.context')->getToken()->getUser();
        $search = $this->em->getRepository('PostBundle:Search')->findAll();
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
        return $this->renderResponse($blockContext->getTemplate(), array(
            'nbposts' => count($posts),
            'view' => $view,
            'mypost' => $mypost,
            'myview' => $myview,
            'search' => count($search),
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}