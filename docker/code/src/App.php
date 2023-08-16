<?php

namespace IilyukDmitryi\App;

use Throwable;

class App
{
    public function run()
    {
        try {
            $this->runAction();
        } catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
    
    private function runAction(): void
    {
        $requestURI = $_SERVER['REQUEST_URI'];
        $segments = explode('/', $requestURI);
        $controllerName = ($segments[1]) ? ucfirst($segments[1]).'Controller' : 'AppController';
        $controllerClass = static::getControllerClassFullName($controllerName);
        $methodName = ($segments[2] ?? 'index')."Action";
        
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
            } else {
                static::show404Page();
            }
        } else {
            static::show404Page();
        }
    }
    
    public static function getControllerClassFullName(string $controllerName): string
    {
        return '\\'.__NAMESPACE__.'\\Controller\\'.$controllerName;
    }
    
    public static function show404Page()
    {
        http_response_code(404);
        $viewPath = $_SERVER['DOCUMENT_ROOT'].'/src/View/404.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo '404 Not Found';
        }
        exit;
    }
}
