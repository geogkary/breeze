<?php

class Breeze
{

    private static $init = false;

    /**
    * @method
    */

    public static function init()
    {
        if (self::$init == true) return;

        header('Content-Type: application/json');


        self::$init = true;
    }

    /**
    * @method
    */

    public static function respond($data = array())
    {
        if (is_array($data)) {
            if (empty($data)) {
                return self::respond('402');
            }

            echo json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );

            return;
        }

        if (isset(self::$errors[$data])) {
            echo json_encode(array(
                'status' => $data,
                'message' => self::$errors[$data]
            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            return;
        }

        echo json_encode(array(
            'status' => '500',
            'message' => self::$errors['500']
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return;
    }

    /**
    * @method
    */

    public static function redirect($string = '')
    {
        if (substr(Flight::request()->url, -1) !== '/' && strpos(Flight::request()->url, '?') == 0) {
            return Flight::redirect(Flight::request()->url . '/');
        }
    }

}
