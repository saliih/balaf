<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 15/05/16
 * Time: 14:34
 */

namespace PostBundle\Admin;

use Knp\Menu\ItemInterface as MenuItemInterface;
use PostBundle\Admin\BaseAdmin as Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class VideosAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'created',

    );

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, array('label' => 'Miniature', 'template' => 'PostBundle:Videos:thumbnail.html.twig'))
            ->add('name')
            ->add('category')
            ->add('createdby')
            ->add('created')
            ->add('act', null, array('editable' => true))
            ->add('trt', null, array('editable' => true))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('url')
            ->add('url2', null, array('required' => false))
            ->add('url3', null, array('required' => false))
            ->add('url4', null, array('required' => false))
            ->add('created', 'sonata_type_date_picker', array('required' => true, 'dp_language' => 'fr', 'format' => 'dd/MM/yyyy'))
            ->add('category', null, array('label' => 'Catégorie','required' => false));

    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->setCreatedby($user);
        $this->updateId($object);

    }

    public function preUpdate($object)
    {
        $this->updateId($object);
    }

    private function updateId($object)
    {
        //$object = new Videos();
        $tab = explode('=', $object->getUrl());
        if (isset($tab[1]))
            $object->setVideosId($tab[1]);
    }

}
