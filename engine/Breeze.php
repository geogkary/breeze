<?php

class Breeze
{

    private static $init = false;

    /**
    * @method
    */

    public static function init()
    {
        header('Content-Type: application/json');

        if (self::$init == true) return;
        
        if (!class_exists('Flight')) {
            if (!file_exists('engine/flight/flight/Flight.php')) {
                return self::respond(array(
                    'status' => '500',
                    'message' => 'Bad configuration - flight framework not detected'
                ));
            }

            require 'engine/flight/flight/Flight.php';
        }

        // 404 requests

        Flight::map('notFound', function() {
            return self::respond('404');
        });

        // Bad requests

        Flight::map('error', function(Exception $error) {
            if (defined('BZ_DEBUG') && BZ_DEBUG === true) {
                return self::respond(array(
                    'status' => '500',
                    'message' => $error->getTraceAsString()
                ));
            }

            return self::respond('500');
        });

        // Home requests

        Flight::route('/', function() {
            $versions = scandir('versions');

            array_shift($versions);
            array_shift($versions);

            var_dump($versions); die;

            return self::respond($versions);
        });

        // Version requests

        // POST requests

        // GET requests


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

        if (isset($bz_errors[$data])) {
            echo json_encode(array(
                'status' => $data,
                'message' => $bz_errors[$data]
            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            return;
        }

        echo json_encode(array(
            'status' => '500',
            'message' => $bz_errors['500']
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
