<?php

declare(strict_types=1);

namespace Dshevchenko\Emailchecker;

use Dshevchenko\Emailchecker\Common;

class App
{
    // Точка входа в приложение
    public function run(): void
    {
        $controllerName = 'Default';
        $methodName = 'render';

        $request = explode('/', $_SERVER['REQUEST_URI']);

        // Извлечение имени котроллера и метода из строки запроса
        if (!empty($request[1])) {
            $controllerName = Common::intoCamelCase($request[1]);
        }
        if (!empty($request[2])) {
            $methodName = Common::intoCamelCase($request[2], true);
        }

        $controllerName .= 'Controller';

        // Проверка наличия класса запрошенного контроллера
        $controllerClassName = 'Dshevchenko\\Emailchecker\\Controllers\\' . $controllerName; 
        if(!class_exists($controllerClassName)) {
            echo "Endpoint '$controllerClassName' not found.";
            return;
        }

        // Создание новго контроллера
        $controller = new $controllerClassName();

        // Проверка наличия метода в контроллере
        if (!method_exists($controller, $methodName)) {
            echo "Method '$methodName' not found.";
            return;
        }

        // Вызов запрошенного метода
        $controller->$methodName();
    }
}
