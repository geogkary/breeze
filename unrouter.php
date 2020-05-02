<?php

/*!
* Breeze PHP
* A simple PHP framework for building APIs.
* https://breezephp.com/
*/

header('Content-Type: application/json');

if (!class_exists('Flight') && file_exists('libraries/flight/Flight.php')) {
    require 'libraries/Flight.php';
} else {
    echo json_encode(array(
        'status' => '500',
        'message' => 'Bad configuration - missing mikecao/flight framework'
    ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

Flight::route('*', function() {
    echo json_encode(array(
        'status' => '404',
        'message' => 'Bad request - incorrect endpoint provided'
    ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
});

Flight::start();

exit();
