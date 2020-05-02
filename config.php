<?php

/*!
* Breeze PHP
* Build JSON APIs with the Breeze framework for PHP.
* https://breezephp.com/
*/

// prefix used for listing your endpoints
define('BZ_ROOT', 'https://breezephp.com/');

// enable listing of endpoints in home requests of versions and endpoints
define('BZ_LIST_ENDPOINTS', true);

// disable debugging for production
define('BZ_DEBUG', true);

// list available and active (aka public) versions
$bz_versions = array(
    'boilerplate' => true
);

// list of errors for your API
$bz_errors = array(
    '200' => 'OK',
    '400' => 'Bad request - missing required parameter(s)',
    '401' => 'Bad request - incorrect parameter(s)',
    '402' => 'Empty response - failed to deliver based on request parameter(s)',
    '403' => 'Forbidden - unauthorized access',
    '404' => 'Not found - incorrect endpoint provided',
    '500' => 'Server - something went wrong'
);
