<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Consumer\Contract\RabbitReceiverInterface;
use Vp\App\Application\Contract\ConsoleDataInterface;
use Vp\App\Application\Contract\DataProcessInterface;

class ConsoleDataProcess implements ConsoleDataInterface, DataProcessInterface
{
    private RabbitReceiverInterface $receiver;

    public function __construct(RabbitReceiverInterface $receiver)
    {
        $this->receiver = $receiver;
    }

    public function work(): void
    {
        $this->receiver->listen(QUEUE_BANK_STATEMENT_PERIOD, $this, 'process');
    }

    public function process(AMQPMessage $msg): void
    {
        fwrite(STDOUT, $msg->getBody() . PHP_EOL);
        $msg->ack($msg->getDeliveryTag());
    }
}
