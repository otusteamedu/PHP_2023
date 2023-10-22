<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Init;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer\ErrorResponse;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Config\IniConfig;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\ConnectionManager;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\HttpApiController\OrderController;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;

class HttpApiInit
{
    const HTTP_API_CONTROLLER_NAMESPACE = 'VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\HttpApiController\\';

    public function run()
    {
        $requestJson = file_get_contents('php://input');
        $requestData = json_decode($requestJson, true);
        if (
            ($_SERVER['REQUEST_METHOD'] !== "GET")
            && (
                ($requestData === false)
                || (!is_array($requestData)
                )
            )
        ) {
            die("Incorrect request JSON!");
        }


        try {
            $this->runController($requestData);
        } catch (\Exception $e) {
            $this->output(
                new ErrorResponse(
                    $e->getMessage()
                )
            );
        } //catch (\Throwable $e) {
        //     $this->output(
        //         new ErrorResponse(
        //             "Internal error occured."
        //         )
        //     );
        // }
    }


    public function runController($requestData)
    {
        $config = new IniConfig();
        $settingsDTO = $config->getAllSettings();
        $connection = new ConnectionManager($settingsDTO);
        $pdo = $connection->getPdo();

        $rabbitHelper = new RabbitMqHelper(
            $connection->getRabbitConnection($settingsDTO)
        );

        $routeConfig = $this->getRouteConfig();
        $controllerClassName = $routeConfig["controllerClass"];
        $controller = new $controllerClassName($pdo, $rabbitHelper);
        
        $controllerMethod = $routeConfig["controllerMethod"];
        $this->output(
            ((object)$controller)->$controllerMethod($requestData)
        );
    }

    public function output($data)
    {
        header("Content-Type: application/json");
        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function getRouteConfig()
    {
        $routeConfig = $this->getAllRoutesConfig();

        if (!isset($routeConfig[$_SERVER['REQUEST_METHOD']])) {
            http_response_code(404);
            exit();
        }
        $currentRequestRoutesList = $routeConfig[$_SERVER['REQUEST_METHOD']];
        if (empty($currentRequestRoutesList)) {
            http_response_code(404);
            exit();
        }

        foreach ($currentRequestRoutesList as $currentRequestRoute) {
            foreach ($currentRequestRoute as $urlPart) {
                if ($_REQUEST["path"] != $urlPart) {
                    break;
                } else {
                    return $currentRequestRoute;
                }
            }
        }

        http_response_code(404);
        exit();
    }

    public function getAllRoutesConfig(): array
    {
        return [
            "GET" => [
                [
                    "requestUrl" => "statement/order/results/",
                    "controllerClass" => self::HTTP_API_CONTROLLER_NAMESPACE . "OrderController",
                    "controllerMethod" => "getOrderResults"
                ],
                [
                    "requestUrl" => "statement/order/status/",
                    "controllerClass" => self::HTTP_API_CONTROLLER_NAMESPACE . "OrderController",
                    "controllerMethod" => "getOrderStatus"
                ]
            ],
            "POST" => [
                [
                    "requestUrl" => "statement/order/",
                    "controllerClass" => self::HTTP_API_CONTROLLER_NAMESPACE . "OrderController",
                    "controllerMethod" => "create"
                ]
            ],
            "PATCH" => [
                [
                    "requestUrl" => "statement/order/",
                    "controllerClass" => self::HTTP_API_CONTROLLER_NAMESPACE . "OrderController",
                    "controllerMethod" => "update"
                ]
            ]
        ];
    }
}
