<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use Exception;
use IilyukDmitryi\App\Application\Dto\TwoNdflRequest;
use IilyukDmitryi\App\Application\UseCase\ReciveTwoNdflUseCase;
use IilyukDmitryi\App\Application\UseCase\SendTwoNdflUseCase;
use Throwable;
use IilyukDmitryi\App\Application\Dto\BankStatementRequest;
use IilyukDmitryi\App\Application\UseCase\ReciveBankStatementUseCase;
use IilyukDmitryi\App\Application\UseCase\SendBankStatementUseCase;
use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;
use IilyukDmitryi\App\Infrastructure\Mailers\MailerApp;
use IilyukDmitryi\App\Infrastructure\Messanger\MessengerApp;

class MessageController
{
    public function reciveBankStatementAction(): void
    {
        ob_start();
        try {
            $messenger = MessengerApp::getMessanger();
            $mailer =  MailerApp::getMailer();
            $reciveBankStatementUseCase = new ReciveBankStatementUseCase($messenger, $mailer);
            $messageReciveResult = $reciveBankStatementUseCase->exec();
            $result['error'] = false;
            $result['message'] = "";
            if (!$messageReciveResult->isMessageRecive()) {
                http_response_code(202);
            } else {
                if (!$messageReciveResult->isSendEmail()) {
                    throw new Exception(
                        "Не удалось сформировать и отправить ответ на ваш емаил, попробуйте позже или обратитесь в службу поддержки"
                    );
                }
                $result['message'] = 'Ваш запрос выполнен. Результат отправлен на ваш емаил';
            }
        } catch (Throwable $th) {
            $result['error'] = true;
            $result['message'] = $th->getMessage();
        }
        header('Content-Type: application/json');
        $returJson = json_encode($result, JSON_UNESCAPED_UNICODE);
        die($returJson);
    }

    public function sendBankStatementAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $messageSendRequest = new BankStatementRequest(
                    $_POST['dateStart'],
                    $_POST['dateEnd'],
                    $_POST['email'],
                );
                $messenger = MessengerApp::getMessanger();
                $messageSendUseCase = new SendBankStatementUseCase($messenger);
                $messageSendUseCase->exec($messageSendRequest);

                $templateData['message'] = 'Запрос отправлен';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }

        $templateData['TITLE'] = 'Запрос банковской выписки';
        $resultHtml = $templateEngine->render('Message/bankstatement.php', $templateData);
        echo $resultHtml;
    }

    public function reciveTwoNdflAction(): void
    {
        ob_start();
        try {
            $messenger = MessengerApp::getMessanger();
            $mailer =  MailerApp::getMailer();
            $reciveBankStatementUseCase = new ReciveTwoNdflUseCase($messenger, $mailer);
            $messageReciveResult = $reciveBankStatementUseCase->exec();
            $result['error'] = false;
            $result['message'] = "";
            if (!$messageReciveResult->isMessageRecive()) {
                http_response_code(202);
            } else {
                if (!$messageReciveResult->isSendEmail()) {
                    throw new Exception(
                        "Не удалось сформировать и отправить ответ на ваш емаил, попробуйте позже или обратитесь в службу поддержки"
                    );
                }
                $result['message'] = 'Ваш запрос выполнен. Результат отправлен на ваш емаил';
            }
        } catch (Throwable $th) {
            $result['error'] = true;
            $result['message'] = $th->getMessage();
        }
        header('Content-Type: application/json');
        $returJson = json_encode($result, JSON_UNESCAPED_UNICODE);
        die($returJson);
    }

    public function sendTwoNdflAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $messageSendRequest = new TwoNdflRequest(
                    (int)$_POST['numMonth'],
                    $_POST['email'],
                );
                $messenger = MessengerApp::getMessanger();
                $messageSendUseCase = new SendTwoNdflUseCase($messenger);
                $messageSendUseCase->exec($messageSendRequest);

                $templateData['message'] = 'Запрос отправлен';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }

        $templateData['TITLE'] = 'Запрос банковской выписки';
        $resultHtml = $templateEngine->render('Message/twondfl.php', $templateData);
        echo $resultHtml;
    }

}
