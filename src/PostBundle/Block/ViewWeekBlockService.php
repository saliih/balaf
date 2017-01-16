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

class ViewWeekBlockService extends BaseBlockService
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
            'title' => 'Les heures pic',
            'template' => 'PostBundle:Block:pick.html.twig',
        ));
    }
    private function getFormatedData($views){
        $final = array();
        foreach ($views as $view) {
            $index = (int)$view->getDv()->format('H');
            if (!isset($final[$index]))
                $final[$index] = 0;
            $final[$index]++;
        }
        ksort($final);
        return $final;
    }
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $views = $this->em->getRepository('PostBundle:Views')->findWeek();
        $final = $this->getFormatedData($views);
        $todayview = $this->em->getRepository('PostBundle:Views')->findToday();
        $today = $this->getFormatedData($todayview);
        $dt = new \DateTime();
        $dt->modify("-1 day");
        $lastday = $this->em->getRepository('PostBundle:Views')->findOneday($dt);
        $last = $this->getFormatedData($lastday);

        return $this->renderResponse($blockContext->getTemplate(), array(
            'final' => $final,
            'today' => $today,
            'last' => $last,
            'title' => "Les heures pic",
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