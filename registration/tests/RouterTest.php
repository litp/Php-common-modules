<?php

require('../public/autoloader.php');

class RouterTest extends PHPUnit_Framework_TestCase
{
	public function testAutoloader()
	{
		$testObject = new Registration();

		$this->assertInstanceOf('Registration', $testObject);
	}

	/**
	 * @dataProvider getQueryPathDataProvider
	 */
	public function testGetQueryPath($requestUri, $scriptName, $expect)
	{
		$_SERVER['REQUEST_URI'] = $requestUri;
		$_SERVER['SCRIPT_NAME'] = $scriptName;

		$this->assertEquals($expect, Router::getQueryPath());
	}

	public function getQueryPathDataProvider()
	{
		return array(
			array('/index.php', '/index.php', '/'),
			array('/index.php/test', '/index.php', '/test')
		);
	}

	public function testDispatch()
	{
		//Router::Dispatch('/register');

		//Router::Dispatch('/register/p1/p2');

		//Router::Dispatch('/register/p1/p2/');

		Router::Dispatch('/Registration/p1');

		Router::Dispatch('/Exceptions/Test/p1/p2');

		$this->assertTrue(true);
	}

}
