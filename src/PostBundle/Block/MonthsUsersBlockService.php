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

class MonthsUsersBlockService extends BaseBlockService
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
            'title' => 'Articles par mois et par Auteurs',
            'template' => 'PostBundle:Block:monthuser.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $posts = $this->em->getRepository('PostBundle:Post')->findAll();
        $final = array();
        $total = 0;
        foreach ($posts as $post) {
            $index = $post->getCreatedby()->getUsername();
            if (!isset($final[$index]))
                $final[$index] = 0;
            $final[$index]++;
            $total ++;
        }
        $final2 = array();
        foreach ($final as $key=>$value){
            $final2[$key]['percent'] =  $value * 100 / $total;
            $final2[$key]['color'] = $this->stringToColorCode($key.rand(84,4898));
        }
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final2,
            'title' => "Article par utilisateur",
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