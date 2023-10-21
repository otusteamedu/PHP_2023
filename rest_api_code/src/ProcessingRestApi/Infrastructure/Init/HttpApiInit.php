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
        $arUrlParts = explode("/" , $_REQUEST["path"]);

        $config = new IniConfig();
        $settingsDTO = $config->getAllSettings();
        $connection = new ConnectionManager($settingsDTO);
        $pdo = $connection->getPdo();

        $rabbitHelper = new RabbitMqHelper(
            $connection->getRabbitConnection($settingsDTO)
        );
        
        $controller = new OrderController($pdo, $rabbitHelper);
        if (
            stripos($_REQUEST["path"], "/status/")
            && ($_SERVER['REQUEST_METHOD'] == "GET")
        ) {
            $method = "getOrderStatus";
            $requestData["id"] = $arUrlParts[3];
        } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $method = "getOrderResults";
            $requestData["id"] = $arUrlParts[2];
        } else if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $method = "create";
        } else if ($_SERVER['REQUEST_METHOD'] == "PATCH") {
            $method = "update";
            $requestData["id"] = $arUrlParts[2];
        } else {
            throw new \Exception("method not implemented yet");
        }

        $this->output(
            ((object)$controller)->$method($requestData)
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
}
