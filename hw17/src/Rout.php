<?php

namespace Builov\Cinema;

use Builov\Cinema\controller\Error404;

class Rout
{
    public function do(): void
    {
        $controller = 'Home';
        $action = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controller = '\Builov\Cinema\controller\\' . ucfirst($routes[1]);

            if (!empty($routes[2])) {
                $action = $routes[2];

                if (!empty($routes[3])) {
                    $args = array_slice($routes, 3);
                }
            }
        }

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller();
            if (isset($args)) {
                $controller->$action(implode(",", $args));
            } else {
                $controller->$action();
            }
        } else {
            Error404::out();
        }
    }
}
