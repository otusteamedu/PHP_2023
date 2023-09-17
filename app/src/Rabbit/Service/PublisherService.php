<?php

declare(strict_types=1);

namespace DEsaulenko\Hw19\Rabbit\Service;

use DEsaulenko\Hw19\Interfaces\PublisherInterface;
use DEsaulenko\Hw19\Interfaces\PublisherServiceInterface;
use DEsaulenko\Hw19\Rabbit\Publisher;
use PhpAmqpLib\Message\AMQPMessage;

class PublisherService implements PublisherServiceInterface
{
    private PublisherInterface $publisher;

    /**
     * @param PublisherInterface $publisher
     */
    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function publish(string $messageBody): void
    {
        $message = new AMQPMessage(
            $messageBody,
            [
                'content_type' => Publisher::DEFAULT_TYPE_MESSAGE,
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->publisher->execute($message);
    }
}
