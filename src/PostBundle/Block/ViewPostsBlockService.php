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

class ViewPostsBlockService extends BaseBlockService
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
            'title' => 'les Articlesles plus visiter par jour',
            'template' => 'PostBundle:Block:viewposts.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $views = $this->em->getRepository('PostBundle:Views')->findToday();
        $final = array();
        $total = 0;
        foreach ($views as $view) {
            $index = $view->getPost()->getId();
            if (!isset($final[$index])) {
                $final[$index] = array('view' => 0, 'post' => $view->getPost());
            }
            $final[$index]['view']++;
        }
        usort($final, function ($a, $b) {
            if (is_numeric($a['view']) && is_numeric($b['view'])) {
                return  -1 *($a['view'] - $b['view']);
            } else {
                return  strcasecmp($a['view'], $b['view']);
            }
        });
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'title' => "les Articles les plus visiter par jour",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }

    private function stringToColorCode($str)
    {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return $code;
    }
}