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
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('parent')
            ->addIdentifier('title', null, array('label' => 'Titre'))
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
        $service = $this->getConfigurationPool()->getContainer()->get('Tools.utils');
        $object->setLocale($locale);
        $object->setSlug($service->slugify($object->getTitle()));
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
            ->tab('Information')
            ->with('Catégorie')
            ->add('title')
            ->add('ord')
            ->add('parent',null,array('required'=>false))
            ->add('description','textarea',array())
            ->end()
            ->end()
            ->tab('SEO')
            ->with('Balise Méta', array('class' => 'col-md-12'))
            ->add("titleSeo", null, array('required' => false))
            ->add("descriptionSeo", 'textarea', array('required' => false))
            ->end()
            ->end()
        ;

    }
}