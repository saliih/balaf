<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 15/05/16
 * Time: 14:34
 */

namespace PostBundle\Admin;

use PostBundle\Admin\BaseAdmin as Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\AdminInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;

class RecettesAdmin extends Admin
{
    public function getname()
    {
        return 'Ramadan';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('datepub')
            ->add('view')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array(),
                )
            ));
    }
    protected function configureFormFields(FormMapper $formMapper)
    {


        $formMapper
            ->add('datepub','sonata_type_date_picker', array('dp_language' => 'fr', 'format' => 'dd/MM/yyyy', 'label' => 'date de publication'))
            ->add('soupe','sonata_type_model', array('required' => true,  'query' =>$this->getCategoryQuery(10), "btn_add"=>false ))
            ->add('salade','sonata_type_model', array('required' => true,  'query' =>$this->getCategoryQuery(11), "btn_add"=>false ))
            ->add('entree','sonata_type_model', array('required' => true,  'query' =>$this->getCategoryQuery(14), "btn_add"=>false ))
            ->add('principal','sonata_type_model', array('required' => true,  'query' =>$this->getCategoryQuery(13), "btn_add"=>false ))
            ->add('patisserie','sonata_type_model', array('required' => true,  'query' =>$this->getCategoryQuery(7), "btn_add"=>false ))
        ;

    }
    private function getCategoryQuery($id){
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $entitySoupe = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository("PostBundle:Category")->find($id);
        $query = $em->createQueryBuilder('c')
            ->select('s')
            ->from('PostBundle:Post', 's')
            ->where('s.ramadan2017 = true')
            ->andWhere('s.category = :category')
            ->setParameter('category',$entitySoupe);
        return $query;
    }
}
