<?php

class Headers implements \IteratorAggregate, \Countable
{
	protected $headers = array();
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

	public function __construct($headers = null)
	{
		$this->headers = $this->validateHeaders($headers);
	}

	protected function validateHeaders($headers)
    {
        $formattedHeaders = array_walk($headers, array($this, formatHeaders));
        $combinedHeaders = array_replace($this->standardHeaders, $formattedHeaders);
        return array_intersect_key($combinedHeaders, $this->standardHeaders);
    }

    protected function formatHeaders(&value, &key)
    {
        $key = implode('-',array_map('ucfirst', explode('-', $key)));
    }        

	public getIterator()
	{
		return \ArrayIterator($this->headers);
	}

	public count()
	{
		return count($this->headers);
	}
}
