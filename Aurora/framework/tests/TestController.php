<?php

/**
 * Created by PhpStorm.
 * User: tianpeng
 * Date: 17/5/16
 * Time: 11:35 PM
 */
class TestController extends Controller
{
    public function test($parameter = 'default')
    {
        echo 'request ' . $this->request->requestUri . ' with arguments ' . $parameter . "\n";
    }
}