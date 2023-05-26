<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use PhpAmqpLib\Message\AMQPMessage;
use Vp\App\Application\Contract\DataProcessInterface;
use Vp\App\Application\Contract\EmailDataInterface;
use Vp\App\Application\Handler\Contract\EmailHandlerInterface;
use Vp\App\Application\RabbitMq\Contract\RabbitReceiverInterface;

class EmailDataProcess implements EmailDataInterface, DataProcessInterface
{
    private RabbitReceiverInterface $receiver;
    private EmailHandlerInterface $handler;

    public function __construct(RabbitReceiverInterface $receiver, EmailHandlerInterface $emailHandler)
    {
        $this->receiver = $receiver;
        $this->handler = $emailHandler;
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
