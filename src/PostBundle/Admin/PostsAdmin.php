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

class PostsAdmin extends Admin
{
    public function getname()
    {
        return 'Articles';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', null, array('label' => 'Titre'))
            ->add('created')
            ->add('publieddate')
            ->add('updated')
            ->add('enabled',null,array('editable'=>true))
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
    public function prePersist($object)
    {
        $local = $this->getConfigurationPool()->getContainer()->get('request')->getLocale();
        $service = $this->getConfigurationPool()->getContainer()->get('Tools.utils');
        $object->setLocale($local);
        $object->setAlias($service->slugify($object->getTitle()));
    }
    public function preUpdate($object)
    {
        $object->setUpdated(new \DateTime());
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Artcile',array('class'=>'col-md-8'))
            ->add('title')
            ->add('article','textarea',array('required'=>false))
            ->end()
            ->with('Status',array('class'=>'col-md-4'))
            ->add('enabled',null,array('required'=>false))
            ->add('publieddate','sonata_type_date_picker',array('dp_language'=>'fr','format'=>'dd/MM/yyyy','label'=>'date de publication'))
            ->add('pic',null,array('required'=>false))
            ->add('category')
        ;

    }
}