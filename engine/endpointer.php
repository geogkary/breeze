<?php

/*!
* Breeze PHP
* A simple PHP framework for building APIs.
* https://breezephp.com/
*/

header('Content-Type: application/json');

echo json_encode(array(
    'status' => '404',
    'message' => 'Bad request - incorrect endpoint provided'
), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

exit();
