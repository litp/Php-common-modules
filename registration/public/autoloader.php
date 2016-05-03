<?php

function autoloader($class)
{
	include(__DIR__ . '/../src/' . $class . '.php');
}

spl_autoload_register('autoloader');
