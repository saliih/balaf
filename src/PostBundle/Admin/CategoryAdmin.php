<?php
namespace PostBundle\Admin;

use PostBundle\Admin\BaseAdmin as Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\AdminInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;
class CategoryAdmin extends Admin
{
    public function getname()
    {
        return 'Categories';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'Titre'))
            ->add('Category', null, array('label' => 'Catégorie'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    // 'view' => array(),
                    'edit' => array(),
                    'delete' => array()

                )
            ));

    }
    protected function configureRoutes(RouteCollection $collection)
    {
        // to remove a single route
       // $collection->remove('create');
        //$collection->remove('delete');
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('description','textarea',array())
        ;

    }
}