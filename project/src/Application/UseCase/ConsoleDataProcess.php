<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Contract\ConsoleDataInterface;
use Vp\App\Application\Contract\DataProcessInterface;
use Vp\App\Application\Handler\Contract\ConsoleHandlerInterface;
use Vp\App\Application\RabbitMq\Contract\RabbitReceiverInterface;

class ConsoleDataProcess implements ConsoleDataInterface, DataProcessInterface
{
    private RabbitReceiverInterface $receiver;
    private ConsoleHandlerInterface $handler;

    public function __construct(RabbitReceiverInterface $receiver, ConsoleHandlerInterface $consoleHandler)
    {
        $this->receiver = $receiver;
        $this->handler = $consoleHandler;
    }

    public function work(): void
    {
        $this->receiver->listen(QUEUE_BANK_STATEMENT_PERIOD, $this, 'process');
    }

    public function process(AMQPMessage $msg): void
    {
        $this->handler->handle($msg);
        $msg->ack($msg->getDeliveryTag());
    }
}
