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

class AlexaAdmin extends Admin
{
    public function getname()
    {
        return 'Alexa';
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper

            ->add('value')
            ->add('dcr')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array(),
                )
            ));
    }
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('value')
        ;

    }
}
