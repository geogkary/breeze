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

        if ($composer) {
            define('BZ_DIR', realpath(__DIR__ . '/../..') . '/breeze/');
        } else {
            define('BZ_DIR', '');
        }

        if (!class_exists('Flight')) {
            if (!file_exists('engine/flight/flight/Flight.php')) {
                self::respond(array(
                    'status' => '500',
                    'message' => 'Bad configuration - Flight framework not detected'
                ));
            }

            require_once 'engine/flight/flight/Flight.php';
        }

        if (!file_exists(BZ_DIR . 'config.php')) {
            self::respond(array(
                'status' => '500',
                'message' => 'Bad configuration - missing config file'
            ));
        }

        require_once BZ_DIR . 'config.php';

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
                self::respond('500');
            });
        }

        // Home requests

        Flight::route('/', function() {
            if (!self::$versions || empty(self::$versions)) {
                self::respond(array(
                    'status' => '500',
                    'message' => 'Bad configuration - API versions not detected'
                ));
            }

            self::endlist(self::$versions);
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
                    self::respond(array(
                        'status' => '404',
                        'message' => 'Not found - requested version does not exist'
                    ));
                }

                require_once 'versions/' . $v . '/API.php';

                // check API configuration

                if (!class_exists('API') || !isset(API::$endpoints) || empty(API::$endpoints)) {
                    self::respond(array(
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

                if (method_exists('API', 'init')) {
                    API::init($request);
                }

                if (isset(API::$keys) && !empty(API::$keys) && (!$key || !in_array($key, API::$keys))) {
                    self::respond('403');
                }

                // check if request is version home

                if (!$endpoint) {
                    self::endlist(API::$endpoints);
                }

                // check if the endpoint exists

                if (!isset(API::$endpoints[$endpoint])) {
                    self::respond('404');
                }

                // check if endpoint home

                $controller;
                $method = 'route' . ucfirst(str_replace('-', '_', $endpoint));
                $class = ucfirst(str_replace('-', '_', $endpoint));
                $file = 'versions/' . $v . '/controllers/' . $class . '.php';

                if (file_exists($file)) {
                    require_once $file;

                    if (class_exists($class)) {
                        $controller = new $class($request, $p1, $p2, $p3, $p4);
                    }
                }

                if (!$call) {
                    if (!$controller && method_exists('API', $method)) {
                        return API::{$method}($request, $p1, $p2, $p3, $p4);
                    }

                    self::endlist(API::$endpoints[$endpoint]);
                }

                // check if the call exists

                if (!isset(API::$endpoints[$endpoint][$call])) {
                    self::respond('401');
                }

                // trigger the endpoint call

                $method .= ucfirst(str_replace('-', '_', $call));

                if (!$controller) {
                    if (!method_exists('API', $method)) {
                        self::respond('200');
                    }

                    return API::{$method}($request, $p1, $p2, $p3, $p4);
                }

                $method = 'route' . ucfirst(str_replace('-', '_', $call));

                if (!method_exists($class, $method)) {
                    self::respond(array(
                        'status' => '500',
                        'message' => 'Bad configuration - API not configured properly'
                    ));
                }

                return $controller->{$method}();
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
                self::respond('402');
            }

            echo json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );

            exit();
        }

        if (isset(self::$errors[$data])) {
            echo json_encode(array(
                'status' => $data,
                'message' => self::$errors[$data]
            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

            exit();
        }

        echo json_encode(array(
            'status' => '402',
            'message' => 'Empty response - failed to deliver based on request parameter(s)'
        ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        exit();
    }

    /**
    * @method
    */

    private static function endlist($endpoints = array())
    {
        $listing = array();

        if (defined('BZ_LIST_ENDPOINTS') && BZ_LIST_ENDPOINTS === true && defined('BZ_ROOT')) {
            foreach ($endpoints as $name => $path) {
                if (is_array($path) && !empty($path)) {
                    if (!isset($listing[$name]) || empty($listing[$name])) {
                        $listing[$name] = array();
                    }

                    foreach ($path as $endpoint => $route) {
                        $listing[$name][$endpoint] = BZ_ROOT . $name . '/';
                    }
                } else {
                    if ($path) {
                        $listing[$name] = BZ_ROOT . $name . '/';
                    }
                }
            }

            if (!empty($listing)) {
                self::respond($listing);
            }
        }

        self::respond('200');
    }

}
