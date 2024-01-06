<?php

namespace App\Application\Action\Notify;

use App\Application\Log\Log;
use NdybnovHw03\CnfRead\Storage;

class TelegramNotify implements NotifyInterface
{
    private Storage $config;
    private Log $log;

    public function __construct(
        Storage $config
    ) {
        $this->config = $config;
        $this->log = new Log();
    }

    public function send(string $content): void
    {
        $decoded = json_decode($content, true);
        $telegramTo = $decoded['user']['telegram'] ?? false;

        if ($telegramTo) {
            $title = $this->takeTitle(
                $telegramTo,
                $this->config->get('NOTIFY_TELEGRAM_API_HASH'),
                $this->config->get('NOTIFY_TELEGRAM_APP_SESSION')
            );
            $this->printMock($title);
            $this->printMock(PHP_EOL);

            $telegramBody = $this->takeDocument(
                $decoded['uid'],
                $decoded['alias'],
                $decoded['start'],
                $decoded['stop'],
                $decoded['user']['title']
            );
            $this->printMock($telegramBody);
            $this->printMock(PHP_EOL);
            $this->printMock(PHP_EOL);
        }
    }

    private function printMock(string $message): void
    {
        $this->log->printOut($message);
    }

    private function takeTitle(
        string $toTelegram,
        string $apiHashTelegram,
        string $sessionTelegram
    ): string {
        return sprintf(
            'Sending `telegram` to Id `%s` Hash `%s` Session `%s`:',
            $toTelegram,
            $apiHashTelegram,
            $sessionTelegram
        );
    }

    private function takeDocument(
        string $number,
        string $caption,
        string $fromDate,
        string $toDate,
        string $account
    ): string {
        return sprintf(
            'Document N `%s` Caption `%s` Period [`%s`, `%s`] for User `%s`',
            $number,
            $caption,
            $fromDate,
            $toDate,
            $account
        );
    }
}
