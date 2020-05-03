<?php

/*!
* Breeze PHP
* Build JSON APIs with the Breeze framework for PHP.
* https://breezephp.com/
*/

class Breeze
{

    public static $versions;

    public static $errors;

    /**
    * @method
    */

    public static function init($composer = false)
    {
        header('Content-Type: application/json');

        if (!class_exists('Flight')) {
            if (!file_exists('engine/flight/flight/Flight.php')) {
                return self::respond(array(
                    'status' => '500',
                    'message' => 'Bad configuration - Flight framework not detected'
                ));
            }

            require_once 'engine/flight/flight/Flight.php';
        }

        if (!file_exists('config.php')) {
            return self::respond(array(
                'status' => '500',
                'message' => 'Bad configuration - missing config file'
            ));
        }

        require_once 'config.php';

        self::$versions = isset($bz_versions) ? $bz_versions : null;
        self::$errors = isset($bz_errors) ? $bz_errors : null;

        // Bad requests & debugging

        if (defined('BZ_DEBUG') && BZ_DEBUG === true) {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);

            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 0);

            Flight::map('error', function() {
                return self::respond('500');
            });
        }

        // Home requests

        Flight::route('GET /', function() {
            if (!self::$versions || empty(self::$versions)) {
                return self::respond(array(
                    'status' => '500',
                    'message' => 'Bad configuration - API versions not detected'
                ));
            }

            if (defined('BZ_LIST_ENDPOINTS') && BZ_LIST_ENDPOINTS === true) {
                $versions = array();

                foreach (self::$versions as $name => $active) {
                    if ($active) {
                        $versions[$name] = BZ_ROOT . $name . '/';
                    }
                }

                if (!empty($versions)) {
                    return self::respond($versions);
                }
            }

            return self::respond('200');
        });

        // All requests

        Flight::route('/@v(/@endpoint(/@call(/@p1(/@p2(/@p3(/@p4))))))',
            function($v, $endpoint, $call, $p1, $p2, $p3, $p4) {
                if (
                    substr(Flight::request()->url, -1) !== '/' &&
                    strpos(Flight::request()->url, '?') == 0
                ) {
                    return Flight::redirect(Flight::request()->url . '/');
                }

                // check version

                if (!isset(self::$versions[$v]) || !file_exists('versions/' . $v . '/API.php')) {
                    return self::respond(array(
                        'status' => '404',
                        'message' => 'Not found - requested version does not exist'
                    ));
                }

                require_once 'versions/' . $v . '/API.php';

                // check API configuration

                if (!class_exists('API') || !isset(API::$endpoints) || empty(API::$endpoints)) {
                    return self::respond(array(
                        'status' => '500',
                        'message' => 'Bad configuration - API not configured properly'
                    ));
                }

                // collect GET/POST data allowed by version

                $key = null;
                $request = array(
                    'data' => array(),
                    'query' => array()
                );

                foreach ($request as $type => $items) {
                    if (!isset(API::${$type})) {
                        break;
                    }

                    foreach ((array) Flight::request()->{$type} as $flight => $collection) {
                        foreach($collection as $item => $value) {
                            if ($item == 'key') {
                                $key = $value;
                                break;
                            }

                            if (!in_array($item, API::${$type})) {
                                break;
                            }

                            $request[$type][$item] = $value;
                        }
                    }

                    if (empty($request[$type])) {
                        $request[$type] = null;
                    }
                }

                if (empty($request['data']) && empty($request['query'])) {
                    $request = null;
                }

                // check for authorization

                if (isset(API::$keys) && !empty(API::$keys) && !$key) {
                    return self::respond('403');
                }

                // check if request is version home

                if (!$endpoint) {
                    if (defined('BZ_LIST_ENDPOINTS') && BZ_LIST_ENDPOINTS === true) {
                        return self::respond(API::$endpoints);
                    }

                    return self::respond('200');
                }

                // check if the endpoint exists

                if (!isset(API::$endpoints[$endpoint])) {
                    return self::respond('404');
                }

                if (method_exists('API', 'init')) {
                    API::init();
                }

                // check if endpoint home

                $method = 'route' . ucfirst(str_replace('-', '_', $endpoint));

                if (!$call) {
                    if (!method_exists('API', $method)) {
                        if (defined('BZ_LIST_ENDPOINTS') && BZ_LIST_ENDPOINTS === true) {
                            return self::respond(API::$endpoints[$endpoint]);
                        }

                        return self::respond('200');
                    }

                    return API::{$method}($request);
                }

                // check if the call exists

                if (!isset(API::$endpoints[$endpoint][$call])) {
                    return self::respond('401');
                }

                // trigger the endpoint call

                $method .= '_' . ucfirst(str_replace('-', '_', $call));

                if (!method_exists('API', $method)) {
                    return self::respond(array(
                        'status' => '500',
                        'message' => 'Bad configuration - API not configured properly'
                    ));
                }

                return API::{$method}($request, $p1, $p2, $p3, $p4);
            }
        );

        Flight::start();
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
            'message' => 'Server - something went wrong'
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        return;
    }

}
