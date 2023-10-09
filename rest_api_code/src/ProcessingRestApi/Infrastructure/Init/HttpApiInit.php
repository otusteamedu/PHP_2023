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

    public function runController__old($requestData)
    {
        $pathParts = explode("/", $_REQUEST["path"]);
        $claccPrefix = ucfirst($pathParts[0]);
        $method = $pathParts[1];

        $config = new IniConfig();
        $connection = new ConnectionManager($config->getAllSettings());
        $pdo = $connection->getPdo();

        $className = self::HTTP_API_CONTROLLER_NAMESPACE . $claccPrefix . "Controller";
        if (
            !class_exists($className)
            || !method_exists($className, $method)
        ) {
            http_response_code(404);
            die();
        }
        $controller = new $className($pdo);
        $this->output(
            ((object)$controller)->$method($requestData)
        );
    }


    public function runController($requestData)
    {
        $pathParts = explode("/", $_REQUEST["path"]);
        $claccPrefix = ucfirst($pathParts[0]);
        $className = self::HTTP_API_CONTROLLER_NAMESPACE . $claccPrefix . "Controller";

        $method = $this->getMethodPrefix($_SERVER['REQUEST_METHOD']);
        for ($i = 1; $i < count($pathParts); $i++) {
            $method .= ucfirst($pathParts[$i]);
        }

        var_dump($className, $method);die();

        if (
            !class_exists($className)
            || !method_exists($className, $method)
        ) {
            http_response_code(404);
            die();
        }

        $config = new IniConfig();
        $connection = new ConnectionManager($config->getAllSettings());
        $pdo = $connection->getPdo();
        $controller = new $className($pdo);
        $this->output(
            ((object)$controller)->$method($requestData)
        );
    }

    protected function getMethodPrefix(string $requestMethod)
    {
        switch ($requestMethod) {
            case "POST":
                return "add";
            case "PUT":
                return "update";
            default:
                return $requestMethod;
        }
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
