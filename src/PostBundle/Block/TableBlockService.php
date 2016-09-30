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
use Sonata\BlockBundle\Block\BaseBlockService  as BaseBlockService;
use Sonata\BlockBundle\Util\OptionsResolver;

class TableBlockService extends BaseBlockService
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
            'url'      => false,
            'title'    => 'Comparatif',
            'template' => 'PostBundle:Block:table.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $posts = $this->em->getRepository('PostBundle:Post')->findBy(array('enabled'=>true));
		$final = array();
		$totalpost = 0;
		$totalview = 0;
		foreach($posts as $post){
			$user = $post->getCreatedby()->getUsername();
			if(!isset($final[$user])){
				$final[$user] = array("post"=>0,"view"=>0);
			}
			$totalpost++;
			$final[$user]["post"]++;
			$final[$user]["view"] += $post->getNbview() ;
			$totalview += $post->getNbview() ;
			
		}
        return $this->renderResponse($blockContext->getTemplate(), array(
            'final'     => $final,
            'totalpost'     => $totalpost,
            'totalview'     => $totalview,
			'title'=>"Comparatif",
            'block'     => $blockContext->getBlock(),
            'settings'  => $settings
        ), $response);
    }
}