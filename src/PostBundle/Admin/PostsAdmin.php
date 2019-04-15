<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 15/05/16
 * Time: 14:34
 */

namespace PostBundle\Admin;

use PostBundle\Admin\BaseAdmin as Admin;
use PostBundle\Entity\Ingredients;
use PostBundle\Entity\Post;
use PostBundle\Entity\Tags;
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
            $datagridMapper
                ->add('twitter')
                ->add('createdby')
                ->add('checkTags')
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
            //->add('publieddate', null, array('template' => 'PostBundle:Post:publieddate.html.twig'))
            ->add('category', null, array('label' => 'Catégorie'))
            ->add('created')->add('updated')
            ->add('nbview', null, array("label" => "real view"))
            /*->add('view', null, array(
                'template' => 'PostBundle:Post:views.html.twig'
            ))*/
            ->add('enabled', null, array('editable' => true))
            ->add('duplicateContent', null, array('editable' => true));

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            /*$listMapper->add('ramadan2017', null, array('label' => 'Ramadan', 'editable' => true))
                // ->add('twitter', null, array('editable' => true))
                //->add('checkTags', null, array('editable' => false, "label"=>"tags"))
            ;*/
        }
        $listMapper->add('_action', 'actions', array(
            'actions' => array(
                // 'view' => array(),
                'edit' => array('template' => "PostBundle:Post:editbt.html.twig"),
                "twitter" => array('template' => "PostBundle:Post:twitter.html.twig"),
                #"View" => array('template' => "PostBundle:Post:viewsbt.html.twig"),
                "preview" => array('template' => "PostBundle:Post:linkpreview.html.twig"),
                //"pie" => array('template' => "PostBundle:Post:pie.html.twig"),
                //"image" => array('template' => "PostBundle:Post:image.html.twig"),
                 'delete' => array('template' => "PostBundle:Post:deletebt.html.twig"),
            )
        ));

    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('batch');
        $collection->remove('delete');
        //$collection->remove('edit');
    }

    private function generateTags(Post $object)
    {
        $tools = $this->getConfigurationPool()->getContainer()->get('Tools.utils');
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $strTags = $object->getStrtags();
        $tags = explode(',', $strTags);
        if (count($tags)) {
            $tagsName = array();
            foreach ($tags as $tag) {
                $tag = trim($tag);
                if ($tag == "") continue;
                $tagObj = $this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('PostBundle:Tags')->findOneBy(array('name' => $tag));
                if ($tagObj == null) {
                    $tagObj = new Tags();
                    $tagObj->setName($tag);
                    $tagObj->setSlug($tools->slugify($tag));
                    $em->persist($tagObj);
                }
                $tagsName[$tag] = $tagObj;
            }
            /** @var Tags $field */
            foreach ($object->getTags() as $field) {
                if (in_array($field->getName(), array_keys($tagsName))) {
                    unset($tagsName[$field->getName()]);
                } else {
                    $object->removeTag($field);
                }
            }
            foreach ($tagsName as $obj) {
                $object->addTag($obj);
            }
            $object->setCheckTags(true);
            $em->flush();
        }

    }

    public function postUpdate($object)
    {
        $this->generateTags($object);

    }

    public function postPersist($object)
    {
        $this->generateTags($object);
    }

    public function prePersist($object)
    {
        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $local = $this->getConfigurationPool()->getContainer()->get('request')->getLocale();
        $service = $this->getConfigurationPool()->getContainer()->get('Tools.utils');
        $object->setLocale($local);
        $object->setAlias($service->slugify($object->getTitle()));
        $object->setCreatedby($user);
        /** @var Ingredients $ingredient */
        foreach ($object->getIngredients() as $ingredient){
            $ingredient->setPost($object);
        }

    }

    public function preUpdate($object)
    {
        $object->setUpdated(new \DateTime());
        /** @var Ingredients $ingredient */
        foreach ($object->getIngredients() as $ingredient){
            $ingredient->setPost($object);
        }
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Article')
            ->with('Artcile', array('class' => 'col-md-8'))
            ->add('title')
            ->add('alias', null, array('required' => false))
            ->add('descript', null, array('required' => false))
            ->add('ingredients', "sonata_type_collection", array(
                'type_options' =>array(
                    // Prevents the "Delete" option from being displayed
                    'delete' => true,

                )
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'true',
            ))
            ->add('article', 'textarea', array('required' => false))
            ->end()
            ->with('Status', array('class' => 'col-md-4'))
            ->add('enabled', null, array('required' => false))
            ->add('publieddate', 'sonata_type_date_picker', array('dp_language' => 'fr', 'format' => 'dd/MM/yyyy', 'label' => 'date de publication'))
            ->add('pic', null, array('required' => false))
            ->add('category', null, array('required' => true))//->add('createdby')
            ->add('strtags', "textarea", array('label' => "tags par virgule", "required" => false))
            ->end()
            ->end()
            ->tab('SEO')
            ->with('Balise Méta', array('class' => 'col-md-12'))
            ->add("titleSeo", null, array('required' => false))
            ->add("descriptionSeo", 'textarea', array('required' => false))
            ->end()
            ->end();
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
