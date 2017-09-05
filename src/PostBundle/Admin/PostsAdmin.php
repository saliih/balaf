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
        $datagridMapper
            ->add('title');
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $datagridMapper->
            add('createdby')
                ->add('enabled')
                ->add('ramadan2017')
                ->add('category');
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('pic', null, array(
                'template' => 'PostBundle:Post:pic.html.twig'
            ))
            ->addIdentifier('title', null, array('label' => 'Titre'))
            ->add('publieddate',null,array('template' => 'PostBundle:Post:publieddate.html.twig'))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('createdby')
            ->add('nbview', null, array("label" => "real view"))
            ->add('view', null, array(
                'template' => 'PostBundle:Post:views.html.twig'
            ))
            ->add('enabled', null, array('editable' => true));
        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $listMapper->add('ramadan2017', null, array('label'=>'Ramadan','editable' => true))
                ->add('twitter', null, array('editable' => true));

        }
        $listMapper->add('_action', 'actions', array(
            'actions' => array(
                // 'view' => array(),
                'edit' => array('template' => "PostBundle:Post:editbt.html.twig"),
                "View" => array('template' => "PostBundle:Post:viewsbt.html.twig"),
                "preview" => array('template' => "PostBundle:Post:linkpreview.html.twig"),
                'delete' => array('template' => "PostBundle:Post:deletebt.html.twig"),
            )
        ));

    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
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
            ->with('Artcile', array('class' => 'col-md-8'))
            ->add('title')
            ->add('alias', null, array('required' => false))
            ->add('article', 'textarea', array('required' => false))
            ->end()
            ->with('Status', array('class' => 'col-md-4'))
            ->add('enabled', null, array('required' => false))
            ->add('publieddate', 'sonata_type_date_picker', array('dp_language' => 'fr', 'format' => 'dd/MM/yyyy', 'label' => 'date de publication'))
            ->add('pic', null, array('required' => false))
            ->add('category', null, array('required' => true))//->add('createdby')
        ;
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
            $query->andWhere(
                $query->expr()->eq($query->getRootAliases()[0] . '.createdby', ':currentuser')
            );
            $query->setParameter('currentuser', $user);
        }
        return $query;

    }
}
