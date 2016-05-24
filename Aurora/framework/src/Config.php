<?php

class Config extends Collection
{
	public function __construct($file = '')
	{
		if (!empty($file)) {
			$config = require $file;
		} else {
			$config = require 'default_config.php';
		}

		parent::__construct($config);
	}
}
