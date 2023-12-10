<?php
declare(strict_types=1);

class Router
{
    private array $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    public function run()
    {
        $uri = $this->getURI();
        foreach($this->routes as $uriPattern => $path)
        {
            if(preg_match("~$uriPattern~", $uri))
            {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                if(file_exists($controllerFile))
                {
                    include_once ($controllerFile);
                }
                $controllerObject = new $controllerName;
                call_user_func_array([$controllerObject, $actionName], $parameters );
                exit;
            }
        }
    }

    private function getURI()
    {
        if(!empty($_SERVER['REQUEST_URI']))
        {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
}