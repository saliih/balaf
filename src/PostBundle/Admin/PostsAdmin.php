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
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')->add('createdby')

            ->add('category');
    }
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('pic', null, array(
                'template' => 'PostBundle:Post:pic.html.twig'
            ))
            ->addIdentifier('title', null, array('label' => 'Titre'))
            ->add('publieddate')
            ->add('enabled',null,array('editable'=>true))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('createdby')->add('nbview')
            ->add('ramadan2017',null,array('editable'=>true))
            ->add('_action', 'actions', array(
                'actions' => array(
                    // 'view' => array(),
                    'edit' => array(),
                    'delete' => array(),
                    "preview"=>array('template'=>"PostBundle:Post:linkpreview.html.twig")
                )
            ));

    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
        $local = $this->getConfigurationPool()->getContainer()->get('request')->getLocale();
        $service = $this->getConfigurationPool()->getContainer()->get('Tools.utils');
        $object->setLocale($local);
        $object->setAlias($service->slugify($object->getTitle()));
        $object->setCreatedby($user);
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
            ->add('alias', null,array('required'=>false))
            ->add('article','textarea',array('required'=>false))
            ->end()
            ->with('Status',array('class'=>'col-md-4'))
            ->add('enabled',null,array('required'=>false))
            ->add('publieddate','sonata_type_date_picker',array('dp_language'=>'fr','format'=>'dd/MM/yyyy','label'=>'date de publication'))
            ->add('pic',null,array('required'=>false))
            ->add('category',null,array('required'=>true))
            //->add('createdby')
        ;

    }
}
