<?php

require('autoloader.php');

$request = Request::constructFromEnvironment();

$router = new Router();

$response = $router->dispatch($request);

//$response->send();
