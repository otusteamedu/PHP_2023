<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Init;

use VKorabelnikov\Hw16\MusicStreaming\Application\DataTransfer\ErrorResponse;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Config\IniConfig;
use VKorabelnikov\Hw16\MusicStreaming\Infrastructure\Storage\ConnectionManager;

class HttpApiInit
{
    const HTTP_API_CONTROLLER_NAMESPACE = 'VKorabelnikov\Hw16\MusicStreaming\Infrastructure\HttpApiController\\';

    public function run()
    {
        $requestJson = file_get_contents('php://input');
        $requestData = json_decode($requestJson, true);
        if (
            ($requestData === false)
            || (!is_array($requestData))
        ) {
            die("Incorrect request JSON!");
        }

        session_start();
        if (
            ($_REQUEST["path"] != "user/auth/")
            && empty($_SESSION["userLogin"])
        ) {
            die("You do not have access permissions!");
        }

        try {
            $this->runController($requestData);
        } catch (\Exception $e) {
            $this->output(
                new ErrorResponse(
                    $e->getMessage()
                )
            );
        } catch (\Throwable $e) {
            $this->output(
                new ErrorResponse(
                    "Internal error occured."
                )
            );
        }
    }

    public function runController($requestData)
    {
        $pathParts = explode("/", $_REQUEST["path"]);
        $claccPrefix = ucfirst($pathParts[0]);
        $method = $pathParts[1];

        $config = new IniConfig();
        $connection = new ConnectionManager($config->getAllSettings());
        $pdo = $connection->getPdo();

        $className = self::HTTP_API_CONTROLLER_NAMESPACE . $claccPrefix . "Controller";
        $controller = new $className($pdo);
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
