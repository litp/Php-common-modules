<?php

class Router
{
    protected $directRouterTable = [
    // 'url' => function
    '/\/register/' => ['Registration', 'register']
    ];

    protected $rootDirectory = __DIR__;
    protected $controllerInstance;


    // return query path starting with '/' and without the last '/'
    public function getQueryPath()
    {
        if (isset($_SERVER['REQUEST_URI']) && isset($_SERVER['SCRIPT_NAME'])) {
            $queryPath = str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);

            if ($queryPath != '') {
                return $queryPath;
            } 
        }
        return '/';
    }


    public function dispatch($queryPath = null)
    {
        if (is_null($queryPath)) {
            $queryPath = $this->getQueryPath();
        }

        // first check if query path matches direct router table
        foreach ($this->$directRouterTable as $uri => $function) {
            if (preg_match($uri, $queryPath, $matches)) {
                $parameterPath = str_replace($matches[0],'',$queryPath);
                if ($parameterPath == '') {
                    $parameters = null;
                } else {
                    $parameters = explode('/',rtrim($parameterPath, '/'));
                    array_shift($parameters);
                }

                //var_dump($function);
                //var_dump($parameters);
                return call_user_func($function,$parameters);
            }
        }


        // try to load the class
        $queryPath = rtrim($queryPath, '/');
        $queryPathParts = explode('/', $queryPath);
        $classPath = $this->rootDirectory;

        // remove the first empty element
        array_shift($queryPathParts);

        foreach ($queryPathParts as $key => $queryPart) {
            if (file_exists($classPath . '/' . $queryPart) && 
                is_dir($classPath . '/' . $queryPart)) {

                    $classPath = $classPath . '/' . $queryPart;
                    var_dump($classPath);

            } elseif (file_exists($classPath . '/' . $queryPart . '.php') && 
                is_file($classPath . '/' . $queryPart . '.php')) {

                //load the class in the file and call the function
                require_once($classPath . '/' . $queryPart . '.php');
                $this->controllerInstance = new $queryPart;

                //var_dump(array($this->controllerInstance, $queryPart));
                //var_dump(array_slice($queryPathParts, $key+1));
                return call_user_func(array($this->controllerInstance, $queryPart), array_slice($queryPathParts, $key+1));               
            } else {
                // throw Bad Request Exception
            }
        }
    }
}
