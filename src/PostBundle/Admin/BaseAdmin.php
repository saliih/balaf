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
        '_per_page' => 20,
    );
    protected $maxPerPage = 20;
    protected $maxPageLinks = 15;
    protected $perPageOptions = array(20, 40, 60, 80, 100, 120, 140);
    protected $listModes = array();
    public function getExportFormats()
    {

        return array(

        );
    }

}