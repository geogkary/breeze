<?php

/*!
* Breeze PHP
* Build JSON APIs with the Breeze framework for PHP.
* https://breezephp.com/
*/

class API
{

    public static $keys = array();

    public static $data = array();

    public static $query = array();

    public static $endpoints = array(
        'info' => array(
            'releases' => 'info/releases(/@release)'
        )
    );

    /**
    * @method
    */

    public static function init()
    {

    }

    /**
    * @method
    */

    public static function routeInfo_Releases($request, $release = null)
    {
        if (!$release) return Breeze::respond('401');

        return Breeze::respond($request);
    }

}
