<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Init;

use VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer\ErrorResponse;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Config\IniConfig;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\ConnectionManager;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\HttpApiController\OrderController;
use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Storage\RabbitMqHelper;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\Exceptions\RouteNotFoundException;

class HttpApiInit
{
    const HTTP_API_CONTROLLER_NAMESPACE = 'VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\HttpApiController\\';

    public function getRequestInput(): array
    {
        $requestData = [];
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $requestData = $_GET;
        } else {
            $requestJson = file_get_contents('php://input');
            if (!empty(trim($requestJson))) {
                $requestData = json_decode($requestJson, true);
                if (!is_array($requestData)) {
                    throw new \Exception("Некорректный JSON!");
                }
            }
        }

        return $requestData;
    }

    public function sendJsonResponseToClient($data, $responseCode = 200)
    {
        header("Content-Type: application/json");
        http_response_code($responseCode);
        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE
        );
    }

    public function run()
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
        $requestData = $this->getRequestInput();
        return ((object)$controller)->$controllerMethod($requestData);
    }

    public function getRouteConfig()
    {
        $routeConfig = $this->getAllRoutesConfig();

        if (!isset($routeConfig[$_SERVER['REQUEST_METHOD']])) {
            throw new RouteNotFoundException();
        }
        $currentRequestRoutesList = $routeConfig[$_SERVER['REQUEST_METHOD']];
        if (empty($currentRequestRoutesList)) {
            throw new RouteNotFoundException();
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

        throw new RouteNotFoundException();
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
