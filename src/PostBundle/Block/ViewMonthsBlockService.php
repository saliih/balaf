<?php

/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 30/09/16
 * Time: 11:00
 */
namespace PostBundle\Block;

use PostBundle\Entity\Post;
use PostBundle\Entity\Views;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Sonata\AdminBundle\Form\FormMapper;
#use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\BaseBlockService as BaseBlockService;
use Sonata\BlockBundle\Util\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class ViewMonthsBlockService extends BaseBlockService
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
            'title' => 'Vues par mois',
            'template' => 'PostBundle:Block:month.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $views = $this->em->getRepository('PostBundle:Views')->find6Months();
        $final = array();
        foreach ($views as $view) {
           if(!isset($final[$view->getDv()->format('Y-m')]))
               $final[$view->getDv()->format('Y-m')] = 0;
            $final[$view->getDv()->format('Y-m')] ++;
        }
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'title' => "Article par mois",
            'block' => $blockContext->getBlock(),
            'settings' => $settings
        ), $response);
    }
}