<?php

class AutoloaderTest extends PHPUnit_Framework_TestCase
{
	public function testLoadFiles()
	{
		$router = new Router();

		$this->assertInstanceOf('Router', $router);
	}

	public function testLoadFileInsideSubdirectory()
	{
		$serverInfo = new ServerInfo(null);

		$this->assertInstanceOf('ServerInfo', $serverInfo);
	}
}