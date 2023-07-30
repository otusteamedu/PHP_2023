<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller\Api\V1;

use Exception;
use IilyukDmitryi\App\Application\Dto\BankStatementRequest;
use IilyukDmitryi\App\Application\Dto\CheckStatusEventRequest;
use IilyukDmitryi\App\Application\Dto\TwoNdflRequest;
use IilyukDmitryi\App\Application\UseCase\CheckStatusRequestUseCase;
use IilyukDmitryi\App\Application\UseCase\SendBankStatementUseCase;
use IilyukDmitryi\App\Application\UseCase\SendTwoNdflUseCase;
use IilyukDmitryi\App\Infrastructure\Http\Controller\Api\ApiControllerInterface;
use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;
use IilyukDmitryi\App\Infrastructure\Messanger\MessengerApp;
use IilyukDmitryi\App\Infrastructure\Storage\StorageApp;
use IilyukDmitryi\App\Infrastructure\UuidGenerator\SimpleGenerator;
use Throwable;

class ApiController implements ApiControllerInterface
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $methodName = $this->getMethodName();
        if ($methodName === '') {
            $this->showSwaggerPage();
        } elseif (method_exists($this::class, $methodName)) {
            $this->$methodName();
        } else {
            throw new Exception("Method '$methodName' not found");
        }
    }

    /**
     * @throws Exception
     */
    private function getMethodName(): string
    {
        $requestMethod = ucfirst(strtolower($_SERVER['REQUEST_METHOD']));
        $segments = explode('/', parse_url($_SERVER['REQUEST_URI'])['path']);
        if (!$segments[3]) {
            return '';
        }

        return $segments[3] . $requestMethod . 'Action';
    }

    protected function showSwaggerPage()
    {
        $templateEngine = new TemplateEngine();

        $resultHtml = $templateEngine->render('API/v1.php',);
        echo $resultHtml;
    }

    public function sendBankStatementRequestPostAction(): void
    {
        ob_start();
        try {
            $uuid = SimpleGenerator::generate();
            $messageSendRequest = new BankStatementRequest(
                $uuid,
                $_POST['dateStart'],
                $_POST['dateEnd'],
                $_POST['email'],
            );
            $messenger = MessengerApp::getMessanger();
            $messageSendUseCase = new SendBankStatementUseCase($messenger);
            $messageSendUseCase->exec($messageSendRequest);
            $response['message'] = 'Запрос отправлен, номер вашего запроса ' . $uuid;
        } catch (Throwable $th) {
            $response['error'] = true;
            $response['message'] = $th->getMessage();
        }
        header('Content-Type: application/json');
        $returJson = json_encode($response, JSON_UNESCAPED_UNICODE);
        die($returJson);
    }

    public function sendTwondflRequestPostAction(): void
    {
        ob_start();
        try {
            $uuid = SimpleGenerator::generate();

            $messageSendRequest = new TwoNdflRequest(
                $uuid,
                (int)$_POST['numMonth'],
                $_POST['email'],
            );
            $messenger = MessengerApp::getMessanger();
            $messageSendUseCase = new SendTwoNdflUseCase($messenger);
            $messageSendUseCase->exec($messageSendRequest);
            $response['message'] = 'Запрос отправлен, номер вашего запроса ' . $uuid;
        } catch (Throwable $th) {
            $response['error'] = true;
            $response['message'] = $th->getMessage();
        }
        header('Content-Type: application/json');
        $returJson = json_encode($response, JSON_UNESCAPED_UNICODE);
        die($returJson);
    }

    public function checkStatusEventGetAction(): void
    {
        ob_start();
        try {
            $checkStatusEventRequest = new CheckStatusEventRequest((string)$_GET['uuid']);
            $storage = StorageApp::getStorage()->getEventStorage();
            $messageSendUseCase = new CheckStatusRequestUseCase($storage);
            $res = $messageSendUseCase->exec($checkStatusEventRequest);
            $response['message'] = $res->getMessage();
        } catch (Throwable $th) {
            $response['error'] = true;
            $response['message'] = $th->getMessage();
        }
        header('Content-Type: application/json');
        $returJson = json_encode($response, JSON_UNESCAPED_UNICODE);
        die($returJson);
    }

}
