<?php

/*!
* Breeze PHP
* Build JSON APIs with the Breeze framework for PHP.
* https://breezephp.com/
*/

class API
{

    public static $keys = array(
        // 'admin' => '::1'
    );

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

    public static function init($request)
    {

    }

    /**
    * @method
    */

    // public static function routeInfo($request, $p1, $p2, $p3, $p4)
    // {
    //     Breeze::respond('200');
    // }

    /**
    * @method
    */

    // public static function routeInfoReleases($request, $p1, $p2, $p3, $p4)
    // {
    //     if (!$p1) Breeze::respond('400');
    //
    //     Breeze::respond(array(
    //         'release' => $p1
    //     ));
    // }

}
