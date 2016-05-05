<?php

require('../public/autoloader.php');

class RequestTest extends PHPUnit_Framework_TestCase
{
	public $request;

	public function setUp()
	{
		$_GET = [];
		$_POST = [];
		$_COOKIE = [];
		$_FILES = [];
		$_SERVER = [];

		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
	}

	public function testConstructor()
	{
		$this->assertInstanceOf('Request', $this->request);
	}

	public function testGetHost()
	{
		$this->assertEquals(false, $this->request->getHost());
		
		$_SERVER['HTTP_HOST'] = 'localhost';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('localhost', $this->request->getHost());
	}

	public function testGetPort()
	{
		$this->assertEquals('80', $this->request->getPort());
		
		$_SERVER['SERVER_PORT'] = '8080';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('8080', $this->request->getPort());
	}

	public function testGetQueryPath()
	{
		$this->assertEquals('/', $this->request->getQueryPath());
		
		$_SERVER['REQUEST_URI'] = '/index.php/test';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('/index.php/test', $this->request->getQueryPath());
	}

	public function testSetScheme()
	{
		$this->assertEquals('http', $this->request->scheme);

		$_SERVER['REQUEST_SCHEME'] = 'https';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('https', $this->request->scheme);
	}

	public function testSetQueryPath()
	{
		$this->assertEquals('/', $this->request->queryPath);

		$_SERVER['REQUEST_URI'] = '/index.php/test';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('/index.php/test', $this->request->queryPath);
	}

	public function testSetMethod()
	{
		$this->assertEquals('GET', $this->request->method);

		$_SERVER['REQUEST_METHOD'] = 'POST';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('POST', $this->request->method);
	}

	public function testScriptName()
	{
		$this->assertEquals('', $this->request->scriptName);

		$_SERVER['SCRIPT_NAME'] = 'index.php';
		$this->request = new Request($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
		$this->assertEquals('index.php', $this->request->scriptName);
	}
}
