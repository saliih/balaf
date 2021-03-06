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

class ViewsAdmin extends Admin
{
    protected $parentAssociationMapping = 'post';
    public function getname()
    {
        return 'View';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('dv')
            ->add('post')
            ->add('referLinks')
            ->add('ip')
            ->add('createdby')
            ->add('mobile')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array(),
                )
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('dv','doctrine_orm_datetime_range', array('field_type'=>'sonata_type_datetime_range_picker'))
            ->add('post')
            ->add('refer')
            ->add('ip')
            ->add('createdby')
        ;

    }

}
