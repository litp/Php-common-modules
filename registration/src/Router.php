<?php

class Router
{
	protected static $directRouterTable = [
	// 'url' => function
	'/register' => ['Registration', 'register']
	];

	public static $rootDirectory = __DIR__;

	// return query path starting with '/' and without the last '/'
	public static function getQueryPath()
	{
		// TODO
		return $queryPath;
	}

	public static function dispatch()
	{
		$queryPath = self::getQueryPath();

		// first check if query path matches direct router table
		foreach  (self::$directRouterTable as $uri => $function) {
			if (preg_match($uri, $queryPath, $matches)) {
				$parameterPath = str_replace($matches[0],'',$uri);
				if ($parameterPath == '') {
					$parameters = null;
				} else {
					$parameters = explode('/',$parameterPath);
				}

				call_user_func($function,$parameters);

				return true;
			}
		}


		// try to load the class
		$queryPathParts = explode('/', $queryPath);
		$classPath = self::$rootDirectory;

		// remove the first empty element
		array_shift($queryPathParts);

		foreach ($queryPathParts as $queryPart) {
			if (file_exists($classPath . '/' . $queryPathParts)) {

				if (is_dir($classPath . '/' . $queryPathParts)) {
					$classPath = $classPath . '/' . $queryPathParts;
				} else if (is_file($classPath . '/' . $queryPathParts)) {
					//load the class in the file and call the function
				}
			} else {
				// throw BadRequestException
			}
		}
	}
}
