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
    }

    public function getHost()
    {
    	if (isset($this->META['HTTP_HOST'])) {
	        return $this->META['HTTP_HOST'];
	    } else {
	    	return false;
	    }
    }

    public function getPort()
    {
    	if (isset($this->META['SERVER_PORT'])) {
	        return $this->META['SERVER_PORT'];
	    } else {
	    	return '80';
	    }
    }

    public function getQueryPath()
    {
    	if (isset($this->META['REQUEST_URI'])) {
    		return $this->META['REQUEST_URI'];
    	} else {
    		return '/';
    	}
        
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

    public function setScheme($scheme = null)
    {
        if (isset($scheme)) {
            $this->scheme = $scheme;
        } elseif (isset($this->META['REQUEST_SCHEME'])) {
            $this->scheme = $this->META['REQUEST_SCHEME'];
        } else {
        	$this->scheme = 'http';
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
        } elseif (isset($this->META['REQUEST_METHOD'])) {
            $this->method = $this->META['REQUEST_METHOD'];
        } else {
        	$this->method = 'GET';
        }

        return $this->method;
    }

    public function setScriptName($scriptName = null)
    {
    	if (isset($scriptName)) {
    		$this->scriptName = $scriptName;
    	} elseif (isset($this->META['SCRIPT_NAME'])) {
    		$this->scriptName = $this->META['SCRIPT_NAME'];
    	} else {
    		$this->scriptName = '';
    	}

    	return $this->scriptName;
    }
}
