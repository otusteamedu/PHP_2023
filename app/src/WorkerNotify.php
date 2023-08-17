<?php

declare(strict_types=1);

namespace Root\App;

use PhpAmqpLib\Message\AMQPMessage;

class WorkerNotify
{
    private Query $query;
    private string $queryName = 'app-notify';

    /**
     * @throws AppException
     */
    public function __construct(Settings $settings)
    {
        $this->query = new Query($settings->get('rabbitmq'), $this->queryName);
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

        echo "Start notification {$data['type']} = {$data['value']} : {$data['message']})" . PHP_EOL;
        sleep(10);
        echo 'End notification' . PHP_EOL;
    }
}
