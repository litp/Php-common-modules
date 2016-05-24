<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
    public $request;

	public function testCreateRequestFromGlobalVariables()
	{
		$this->setupEnvs();

		$request = Request::createFromEnvironments();

		$this->assertInstanceOf('Request', $request);
        $this->assertEquals('GET', $request->method);
        $this->assertEquals('/index.php/help', $request->requestUri);
        $this->assertEquals('HTTP/1.1', $request->httpVersion);
	}

	protected function setupEnvs()
	{
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_SERVER['REQUEST_URI'] = '/index.php/help';
		$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
		$_SERVER['HTTP_ACCEPT'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
		$_SERVER['HTTP_ACCEPT_CHARSET'] = '';
		$_SERVER['HTTP_ACCEPT_ENCODING'] = '';
		$_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
		$_SERVER['HTTP_HOST'] = 'www.my';
		$_SERVER['HTTP_CONNECTION'] = 'keep-alive';
		$_SERVER['HTTP_REFERER'] = '';
		$_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5)';
		$_SERVER['SCRIPT_NAME'] = '/index.php';
    }

    public function setUp()
    {
        $this->request =  new Request('GET', '/', 'HTTP/1.1');
    }

    public function testInstacneRequest()
    {
        $this->assertInstanceOf('Request', $this->request);
    }

    public function testSetHeaders()
    {
        $this->setupEnvs();
        $this->request = Request::createFromEnvironments();

        $this->assertEquals('www.my', $this->request->headers->Host);
        $this->assertEquals('/index.php', $this->request->serverInfo->scriptName);
    }

    public function testMethodFormatedHeaders()
    {
        $formated = $this->request->formatHeaders(array('accept-charset' => 'utf8'));

        $this->assertArrayHasKey('Accept-Charset', $formated);
        $this->assertEquals('utf8', $formated['Accept-Charset']);
    }
}
