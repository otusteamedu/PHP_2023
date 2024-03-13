<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Consumer;

use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use Shabanov\Otusphp\Connection\ConnectionInterface;
use Shabanov\Otusphp\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;

class RabbitMqConsumer
{
    private AMQPChannel|AbstractChannel $channel;
    private string $queue;

    public function __construct(private readonly ConnectionInterface $connect,
                                private readonly OutputInterface $output
    ) {
        $this->channel = $this->connect->getClient();
        $this->queue = $_ENV['QUEUE'];
    }

    public function run(): void
    {
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            true,
            false,
            false,
            [$this, 'consumeHandler']
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

        $this->close();
    }

    public function consumeHandler(AMQPMessage $message): void
    {
        /**
         * Выведим в консоль данные
         */
        $this->output->writeln('<info>[x] ' . $message->body . '</info>');
        /**
         * Отправим строку на Email
         */
        (new Mailer($message->body))->send();
    }

    private function close(): void
    {
        $this->channel->close();
        $this->connect->close();
    }
}
