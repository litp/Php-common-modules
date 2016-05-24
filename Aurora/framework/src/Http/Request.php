<?php

class Request
{
    protected $standardHeaders = array(
        // General headers
        'Cache-Control'            => '',
        'Connection'               => '',
        'Date'                     => '',
        'Pragma'                   => '',
        'Trailer'                  => '',
        'Transfer-Encoding'        => '',
        'Upgrade'                  => '',
        'Via'                      => '',
        'Warning'                  => '',
        // Request headers
        'Accept'                   => '',
        'Accept-Charset'           => '',
        'Accept-Encoding'          => '',
        'Accept-Language'          => '',
        'Authorization'            => '',
        'Expect'                   => '',
        'From'                     => '',
        'Host'                     => '',
        'If-Match'                 => '',
        'If-Modified-Since'        => '',
        'If-None-Match'            => '',
        'If-Range'                 => '',
        'If-Unmodified-Since'      => '',
        'Max-Forwards'             => '',
        'Proxy-Authorization'      => '',
        'Range'                    => '',
        'Referer'                  => '',
        'TE'                       => '',
        'User-Agent'               => '',
    );
	public $method;
	public $requestUri;
	public $httpVersion;

	public $headers;
	public $body;
	public $cookies;

	public $GET;
	public $POST;

	public $serverInfo;

	public function __construct($method, $requestUri, $httpVersion, $headers = array(), $body = null, $cookies = array(), $GET = array(), $POST = array(), $serverInfo = array())
	{
		$this->method = $method;
		$this->requestUri = $requestUri;
		$this->httpVersion = $httpVersion;

        $this->setHeaders($headers);
		$this->body = $body;
		$this->cookies = $cookies;
		$this->GET = $GET;
		$this->POST = $POST;
		$this->setServerInfo($serverInfo);
	}

	public static function createFromEnvironments()
	{
		$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		$requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
		$httpVersion = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';

        // Construct headers from envs
        $headers['Accept'] = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : '';
        $headers['Accept-Charset'] = isset($_SERVER['HTTP_ACCEPT_CHARSET']) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : '';
        $headers['Accept-Encoding'] = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '';
        $headers['Accept-Language'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
        $headers['Host'] = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
        $headers['Connection'] = isset($_SERVER['HTTP_CONNECTION']) ? $_SERVER['HTTP_CONNECTION'] : '';
        $headers['Referer'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $headers['User-Agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        
		$body = file_get_contents('php://input');
		$cookies = $_COOKIE; //TODO: create a Cookie class to encapsulate $_COOKIE
		$GET = $_GET;
		$POST = $_POST;

        // Construct server info
        $serverInfo['scriptName'] = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';

		return new Request($method, $requestUri, $httpVersion, $headers, $body, $cookies, $GET, $POST, $serverInfo);
	}
    
    public function setHeaders($headers)
    {
        $headers = $this->formatHeaders($headers);
        $this->headers = new Collection($headers);
        
        return $this;
    }

    public function formatHeaders($headers)
    {
        $formated = array();

        foreach ($headers as $key => $value) {
            $formated[implode('-',array_map('ucfirst', explode('-', $key)))] = $value;
        }

        $mergedHeaders = array_replace($this->standardHeaders, $formated);
        return array_intersect_key($mergedHeaders, $this->standardHeaders);
    }

    public function setServerInfo($serverInfo)
    {
        $this->serverInfo = new Collection($serverInfo);

        return $this;
    }    
}
