<?php

declare(strict_types=1);

namespace App\Infrastructure\Component;

use App\Application\Command\ProcessBankStatementCommand;
use App\Application\Command\ProcessBankStatementCommandHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class Consumer
{
    public function __construct(
        private readonly string $exchange,
        private readonly string $queue,
        private readonly AMQPStreamConnection $amqpConnection,
        private readonly ProcessBankStatementCommandHandler $processBankStatementCommandHandler,
    ) {
    }

    public function __destruct()
    {
        $this->amqpConnection->close();
    }

    public function consume(\Closure $callback): void
    {
        $consumerTag = 'consumer' . getmypid();
        $channel = $this->amqpConnection->channel();
        $channel->queue_declare($this->queue, false, false, false, false);
        $channel->exchange_declare($this->exchange, AMQPExchangeType::FANOUT, false, false, false);
        $channel->queue_bind($this->queue, $this->exchange);
        $channel->basic_consume(
            $this->queue,
            $consumerTag,
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) use ($callback) {
                call_user_func($callback, sprintf('Handling: %s.', $message->getBody()));
                $result = $this->handleMessage($message);
                call_user_func($callback, sprintf('Handled: %s.', $result));
            },
        );

        while ($channel->is_consuming()) {
            $channel->wait(null, true);
        }
    }

    private function handleMessage(AMQPMessage $message): string
    {
        $command = unserialize($message->body);
        if ($command instanceof ProcessBankStatementCommand) {
            $this->processBankStatementCommandHandler->handle($command);
        }

        $message->ack();

        return sprintf(
            '%s(%s, %s)',
            $command::class,
            $command->dateFrom->format('c'),
            $command->dateTo->format('c'),
        );
    }
}
