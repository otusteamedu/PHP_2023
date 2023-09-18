<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use Exception;
use IilyukDmitryi\App\Application\Dto\MessageBankStatement;
use IilyukDmitryi\App\Application\UseCase\ReciveBankStatementUseCase;
use IilyukDmitryi\App\Application\UseCase\SendBankStatementUseCase;
use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;
use IilyukDmitryi\App\Infrastructure\Mailer\Mailer;
use IilyukDmitryi\App\Infrastructure\Repository\BankStatementReciver;
use IilyukDmitryi\App\Infrastructure\Repository\BankStatementSender;
use Throwable;

class MessageController
{
    public function reciveAction(): void
    {
        ob_start();
        try {
            $reciver = new BankStatementReciver();
            $mailer = new Mailer();
            $reciveBankStatementUseCase = new ReciveBankStatementUseCase($reciver, $mailer);
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

    public function sendAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $messageSendRequest = new MessageBankStatement(
                    $_POST['dateStart'],
                    $_POST['dateEnd'],
                    $_POST['email'],
                );
                $sender = new BankStatementSender();
                $messageSendUseCase = new SendBankStatementUseCase($sender);
                $messageSendUseCase->exec($messageSendRequest);

                $templateData['message'] = 'Запрос отправлен';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }

        $templateData['TITLE'] = 'Запрос банковской выписки';
        $resultHtml = $templateEngine->render('Message/send.php', $templateData);
        echo $resultHtml;
    }
}
