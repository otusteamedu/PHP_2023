<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Contract\DataProcessInterface;
use Vp\App\Application\Contract\OrderDataInterface;
use Vp\App\Application\QueueNames;
use Vp\App\Application\RabbitMq\Contract\RabbitReceiverInterface;
use Vp\App\Application\UseCase\Contract\OrderHandlerInterface;

class OrderDataProcess implements OrderDataInterface, DataProcessInterface
{
    private RabbitReceiverInterface $receiver;
    private OrderHandlerInterface $handler;

    public function __construct(RabbitReceiverInterface $receiver, OrderHandlerInterface $orderHandler)
    {
        $this->receiver = $receiver;
        $this->handler = $orderHandler;
    }

    public function work(): void
    {
        $this->receiver->listen(QueueNames::orderHandle->name, $this, 'process');
    }

    public function process(AMQPMessage $msg): void
    {
        $this->handler->handle($msg);
        $msg->ack($msg->getDeliveryTag());
    }
}
