<?php
/**
 * Created by PhpStorm.
 * User: sarra
 * Date: 20/05/16
 * Time: 17:52
 */

namespace PostBundle\Services;


class NewsServices
{
    protected $container;

    /*public function __construct($container)
    {
        $this->container = $container;
    }*/
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}