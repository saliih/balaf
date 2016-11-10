<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 01/05/16
 * Time: 10:34
 */

namespace PostBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;

class BaseAdmin extends Admin
{
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_page' => 1,
        '_per_page' => 25,
    );
    protected $maxPerPage = 25;
    protected $maxPageLinks = 25;
    protected $translationDomain = 'MainFactBundle';
    protected $perPageOptions = array(25, 50, 75, 100, 125, 150);
    protected $listModes = array();
    public function getExportFormats()
    {
        return array(

        );
    }

}