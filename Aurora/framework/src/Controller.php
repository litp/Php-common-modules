<?php

/**
 * Created by PhpStorm.
 * User: tianpeng
 * Date: 17/5/16
 * Time: 11:32 PM
 */
class Controller
{
    protected $request;
    protected $application;

    public function __construct($application, $request)
    {
        $this->request = $request;
        $this->application = $application;
    }
}