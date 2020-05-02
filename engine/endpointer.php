<?php

/*!
* Breeze PHP
* Build JSON APIs with the Breeze framework for PHP.
* https://breezephp.com/
*/

header('Content-Type: application/json');

echo json_encode(array(
    'status' => '404',
    'message' => 'Not found - requested version does not exist'
), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

exit();
