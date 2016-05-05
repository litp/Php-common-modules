<?php

class Request
{
    protected static $instance;

    public $scheme;
    public $body;
    public $queryPath;
    public $scriptName;
    public $method;
    public $encoding;

    public $GET;
    public $POST;
    public $COOKIES;
    public $FILES;
    public $META;

    public static function create()
    {
        if (empty(self::$instance)) {
            self::$instance = self::constructFromEnvironment();
        }

        return self::$instance;
    }

    public static function constructFromEnvironment()
    {
        self::$instance = new Request(  $_GET,
                                        $_POST,
                                        $_COOKIES,
                                        $_FILES,
                                        $_SERVER);
        return self::$instance;
    }

    public function __construct($get = array(),
                                $post = array(),
                                $cookies = array(),
                                $files = array(),
                                $servers = array())
    {
        $this->GET = $get;
        $this->POST = $post;
        $this->COOKIES = $cookies;
        $this->FILES = $files;
        $this->META = $servers;

        $this->setScheme();
        $this->setQueryPath();
        $this->setScriptName();
        $this->setMethod();
        $this->setEncoding();
    }



    public function getHost()
    {
        return $this->META['HTTP_HOST'];
    }

    public function getPort()
    {
        return $this->META['SERVER_PORT'];
    }

    public function getQueryPath()
    {
        return $this->META['REQUEST_URI'];
    }

    public function buildAbsoluteUri()
    {
        //
    }

    public function isSecure()
    {
        //
    }

    public function isAjax()
    {
        //
    }

    public function setScheme($scheme = 'http')
    {
        if (isset($this->META['REQUEST_SCHEME'])) {
            $this->scheme = $this->META['REQUEST_SCHEME'];
        } else {
            $this->scheme = $scheme;
        }
    }

    public function setQueryPath($path = null)
    {
    	if (isset($path)) {
	        $this->queryPath = $path;
	    } else {
	    	$this->queryPath = $this->getQueryPath();
	    }

	    return $this->queryPath;
    }

    public function setMethod($method = null)
    {
        if (isset($method)) {
            $this->method = $method;
        } else {
            $this->method = $this->META['REQUEST_METHOD'];
        }

        return $this->method;
    }

    public function setEncoding()
    {
        //
    }

    public function setScriptName($scriptName = null)
    {
    	if (isset($scriptName)) {
    		$this->scriptName = $scriptName;
    	} else {
    		$this->scriptName = $this->META['SCRIPT_NAME'];
    	}

    	return $this->scriptName;
    }
}
