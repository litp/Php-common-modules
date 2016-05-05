<?php

require('autoloader.php');

$request = new Request();

$router = new Router();

$router->dispatch($request);
