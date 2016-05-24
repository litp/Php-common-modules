<?php

class ConfigTest extends PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp()
    {
        $this->config = new Config('config.test.php');
    }

    public function testLoadConfig()
    {
        $this->assertInstanceOf('Config', $this->config);
    }

    public function testLoadedConfigArray()
    {
        $this->assertEquals('for testing', $this->config->ForTest);

        $this->assertArrayHasKey('/test', $this->config->Router['router_table']);
    }
}