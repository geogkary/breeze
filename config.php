<?php

/*!
* Breeze PHP
* A simple PHP framework for building APIs.
* https://breezephp.com/
*/

define('BZ_ROOT', 'https://breezephp.com/');
define('BZ_LIST_ENDPOINTS', true);
define('BZ_DEBUG', true);

$bz_versions = array(
    'boilerplate' => true
);

$bz_errors = array(
    '200' => 'OK',
    '400' => 'Bad request - missing required parameter(s)',
    '401' => 'Bad request - incorrect parameter(s)',
    '402' => 'Empty response - failed to deliver based on request parameter(s)',
    '403' => 'Forbidden - unauthorized access',
    '404' => 'Not found - incorrect endpoint provided',
    '500' => 'Server - something went wrong'
);
