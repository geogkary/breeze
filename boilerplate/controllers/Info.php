<?php

/*!
* Breeze PHP
* Build JSON APIs with the Breeze framework for PHP.
* https://breezephp.com/
*/

class Info
{

    protected $request;

    protected $release;

    /**
    * @method
    */

    public function __construct($request, $p1, $p2, $p3, $p4)
    {
        $this->request = $request;
        $this->release = $p1;
    }

    /**
    * @method
    */

    public function routeReleases()
    {
        if (!$this->release) Breeze::respond('400');

        Breeze::respond(array(
            'release' => $this->release
        ));
    }

}
