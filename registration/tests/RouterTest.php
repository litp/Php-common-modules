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

}
