<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use Exception;
use Throwable;

class ApiController
{
    public const API_CONTROLLER_RUN_METHOD = 'run';

    public function v1Action(): void
    {
        ob_start();
        $result = [];
        try {
            $requestURI = $_SERVER['REQUEST_URI'];
            $controllerClass = __NAMESPACE__ . "\\Api\\v1\\ApiController";

            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                $methodName = static::API_CONTROLLER_RUN_METHOD;
                if (method_exists($controller, $methodName)) {
                    $controller->$methodName();
                } else {
                    throw new Exception("Controller method not found for API");
                }
            } else {
                throw new Exception("Controller class not found for");
            }
        } catch (Throwable $th) {
            $result['error'] = true;
            $result['message'] = $th->getMessage();
            header('Content-Type: application/json');
            $returnJson = json_encode($result, JSON_UNESCAPED_UNICODE);
            die($returnJson);
        }
    }
}
