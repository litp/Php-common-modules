<?php

class RouterTest extends PHPUnit_Framework_TestCase
{
    protected $request;
    protected $router;
    protected $config;
    protected $app;

    public function setUp()
    {
        $this->config = new Config('config.test.php');
        $this->app = new Application();
        $this->app->config = $this->config;
        $this->router = new Router($this->app);
    }


    public function testEscapeRouterTable()
    {
        $testTable = array(
            '/test' => 'test'    
        );

        $escaped = $this->router->escapeRouterTable($testTable);

        $this->assertArrayHasKey("/\/test/", $escaped);
    }

    public function testGetQueryPath()
    {
        $this->request = new Request(
            'GET',              //method
            '/index.php/test',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
                )             
            );

        $result = $this->router->getQueryPath($this->request);

        $this->assertEquals('/test', $result);
    }

    public function testDispatchWithNoParameter()
    {
        $this->request = new Request(
            'GET',              //method
            '/index.php/test',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
                )             
            );

        $this->router->dispatch($this->request);
    }
    
    public function testDispatchWithOneArgument()
    {
        $this->request = new Request(
            'GET',              //method
            '/index.php/test/p1',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
            )
        );

        $this->router->dispatch($this->request);
        
        //$this->expectOutputString();
    }
    
    public function testDispatchWithMultiParameters()
    {
        $this->request = new Request(
            'GET',              //method
            '/index.php/test/p1/p2',  //requestUri
            'HTTP/1.1',         //version
            array(),            //headers
            '',                 //body
            array(),            //cookies
            array(),            //GET
            array(),            //POST
            array(              // serverInfo
                'scriptName' => '/index.php'
            )
        );
        
        $this->router->dispatch($this->request);
    }
}
