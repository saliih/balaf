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
            ->add('color')
            ->add('ord')
            ->add('_action', 'actions', array(
                'actions' => array(
                    // 'view' => array(),
                    'edit' => array(),
                    'delete' => array()

                )
            ));

    }
    public function prePersist($object)
    {
        $locale = $this->getConfigurationPool()->getContainer()->get('request')->getLocale();
        $object->setLocale($locale);
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
            ->add('color', "choice", array('label' => 'Couleur','choices'  => array(
                'carrot' => 'carrot',
                'blue2' => 'blue2',
                'blue' => 'blue',
                'red' => 'red',
                'yellow' => 'yellow',
                'green' => 'green',
                'pink' => 'pink',
                'purple' => 'purple',
            )))
            ->add('description','textarea',array())
        ;

    }
}