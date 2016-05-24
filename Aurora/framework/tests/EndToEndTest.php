<?php

class EndToEndTest extends PHPUnit_Framework_TestCase
{
    public function testRequestRouteAndResponse()
    {
        // Setup environments
        $this->setupEnvs();
        $request = Request::createFromEnvironments();

        $config = new Config('config.test.php');
        $app = new Application(array('config' => $config));
        $app->router = new Router($app);

        $app->router->dispatch($request);

        //$this->expectOutput('');
    }

    protected function setupEnvs()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
        $_SERVER['HTTP_ACCEPT'] = '';
        $_SERVER['HTTP_ACCEPT_CHARSET'] = '';
        $_SERVER['HTTP_ACCEPT_ENCODING'] = '';
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
        $_SERVER['HTTP_HOST'] = '';
        $_SERVER['HTTP_CONNECTION'] = '';
        $_SERVER['HTTP_REFERER'] = '';
        $_SERVER['HTTP_USER_AGENT'] = '';
        $_SERVER['SCRIPT_NAME'] = '/';
    }
}