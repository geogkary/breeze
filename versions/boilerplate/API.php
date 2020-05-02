<?php

class API
{

    public static $active = true;

    public static $keys = array();

    public static $endpoints = array();

    public static $errors = array(
        '400' => 'Bad request - missing required parameter(s)',
        '401' => 'Bad request - incorrect parameter(s)',
        '402' => 'Empty response - failed to deliver based on request parameter(s)',
        '403' => 'Forbidden - unauthorized access',
        '404' => 'Not found - incorrect endpoint provided',
        '500' => 'Server - something went wrong'
    );

    public static $db = array();

    /**
    * @method
    */

    public function __construct()
    {
        var_dump(1); die;
    }

}
