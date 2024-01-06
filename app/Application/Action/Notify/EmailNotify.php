<?php

namespace App\Application\Action\Notify;

use App\Application\Log\Log;
use NdybnovHw03\CnfRead\Storage;

class EmailNotify implements NotifyInterface
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
        $emailTo = $decoded['user']['email'] ?? false;

        if ($emailTo) {
            $title = $this->takeTitle(
                $emailTo,
                $this->config->get('NOTIFY_EMAIL_FROM'),
                $this->config->get('NOTIFY_EMAIL_TOPIC')
            );
            $this->printMock($title);
            $this->printMock(PHP_EOL);

            $emailBody = $this->takeDocument(
                $decoded['uid'],
                $decoded['alias'],
                $decoded['start'],
                $decoded['stop'],
                $decoded['user']['title']
            );
            $this->printMock($emailBody);
            $this->printMock(PHP_EOL);
            $this->printMock(PHP_EOL);
        }
    }

    private function printMock(string $message): void
    {
        $this->log->printOut($message);
    }

    private function takeTitle(
        string $toEmail,
        string $fromEmail,
        string $topic
    ): string {
        return sprintf(
            'Sending `email` to `%s` from `%s` topic `%s`:',
            $toEmail,
            $fromEmail,
            $topic
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
