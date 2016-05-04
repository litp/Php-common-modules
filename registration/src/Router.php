<?php

class Router
{
    protected static $directRouterTable = [
    // 'url' => function
    '/register' => ['Registration', 'register']
    ];

    public static $rootDirectory = __DIR__;
    public static $controllerInstance;

    // return query path starting with '/' and without the last '/'
    public static function getQueryPath()
    {
        if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SCRIPT_NAME'])) {
            $queryPath = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

            if ($queryPath != '') {
                return $queryPath;
            } 
        }
        return '/';
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

        foreach ($queryPathParts as $key => $queryPart) {
            if (file_exists($classPath . '/' . $queryPath)) {

                if (is_dir($classPath . '/' . $queryPath)) {
                    $classPath = $classPath . '/' . $queryPath;
                } elseif (is_file($classPath . '/' . $queryPath)) {
                    //load the class in the file and call the function
                    require($classPath . '/' . $queryPath . '.php');
                    self::$controllerInstance = new $queryPath;

                    call_user_func(array(self::$controllerInstance, $queryPart), array_slice($queryPathParts, $key+1));

                    return true;
                }

            } else {
                // throw Exception
            }
        }
    }
}
