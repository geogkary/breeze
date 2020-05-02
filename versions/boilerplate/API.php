<?php

class API
{

    public static $endpoints = array(
        'info' => array(
            'releases' => 'info/releases(/@release)/'
        )
    );

    public static $data = array();

    public static $query = array(
        'test'
    );

    public static $keys = array();

    public static function routeInfo_Releases($request, $p1)
    {
        var_dump($request, $p1);
    }

}
