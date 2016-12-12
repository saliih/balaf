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

class TasksAdmin extends Admin
{
    public function getname()
    {
        return 'Liste des tâches';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('name')
            ->add('dcr')
            ->add('act',null,array('editable'=>true))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array(),
                )
            ));
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('body')
        ;

    }
}
