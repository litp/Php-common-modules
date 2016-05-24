<?php
class Router
{
    protected $app;

    protected $directRouterTable = array();
    protected $rootDirectory = '';  //unused yet!!
    protected $controllerInstance;
    
    public function __construct($app)
    {
        $this->app = $app;
        $this->directRouterTable = $this->escapeRouterTable($this->app->config->Router['router_table']);
    }

    public function escapeRouterTable($routerTable)
    {
        $escapedRouterTable = array();

        foreach ($routerTable as $regex => $function) {
            $escapedRouterTable['/' . addcslashes(rtrim($regex, '/'), "\'\"\\\/") . '/'] = $function;
        }

        return $escapedRouterTable;
    }

    // return query path starting with '/' and without the last '/'
    public function getQueryPath($request)
    {
        if (isset($request) && 
            isset($request->serverInfo->scriptName) &&
            isset($request->requestUri)) {
            
            $queryPath = str_replace($request->serverInfo->scriptName, '', $request->requestUri);

            return empty($queryPath) ? '/' : $queryPath;

        } else {
            return '/';
        }
    }

    public function dispatch($request = null)
    {
        $queryPath = $this->getQueryPath($request);

        foreach ($this->directRouterTable as $uriRegex => $function) {
            if (preg_match($uriRegex, $queryPath, $matches)) {
                $parameterPath = str_replace($matches[0],'',$queryPath);
                if ($parameterPath == '') {
                    $parameters = array();
                } else {
                    $parameters = explode('/',rtrim($parameterPath, '/'));
                    array_shift($parameters);
                }

                if (!is_array($function)) {
                    return call_user_func($function, $parameters);
                } else {
                    $function[0] = new $function[0]($this->app, $request);
                    call_user_func_array($function,$parameters);
                }

            }
        }
    }
}
