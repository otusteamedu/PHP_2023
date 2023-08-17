<?php

declare(strict_types=1);

namespace Root\App;

use PhpAmqpLib\Message\AMQPMessage;

class WorkerExec
{
    private Query $query;
    private Query $queryNotify;
    private string $queryNameNotify = 'app-notify';

    /**
     * @throws AppException
     */
    public function __construct(Settings $settings)
    {
        $this->query = new Query($settings->get('rabbitmq'));
        $this->queryNotify = new Query($settings->get('rabbitmq'), $this->queryNameNotify);
    }

    /**
     * @throws AppException
     */
    public function listen(): void
    {
        $this->query->listen([$this, 'execute']);
    }

    public function execute(AMQPMessage $message): void
    {
        $data = json_decode($message->getBody(), true);
        if (!is_array($data) || count($data) === 0) {
            return;
        }

        $start = $data['start'] ?? null;
        $end = $data['end'] ?? null;
        $notification = $data['notification'] ?? [];
        if (!is_array($notification)) {
            $notification = [];
        }

        if (empty($start) || empty($end)) {
            return;
        }

        $this->generateBankStatement($start, $end);
        if (!empty($notification)) {
            foreach ($notification as $type => $item) {
                /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
                $this->notification($type, $item, "Bank statement from {$start} to {$end} created");
            }
        }
    }

    private function generateBankStatement(string $start, string $end): void
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        echo "Start generateBankStatement({$start}, {$end})" . PHP_EOL;
        sleep(10);
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        echo "End generateBankStatement({$start}, {$end})" . PHP_EOL;
    }
    private function notification(string $type, string $value, string|array $message): void
    {
        /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
        echo "Start notification({$type}, {$value}, {$message})" . PHP_EOL;
        $this->queryNotify->publish(['type' => $type, 'value' => $value, 'message' => $message]);
    }
}
