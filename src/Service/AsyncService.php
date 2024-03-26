<?php
declare(strict_types=1);

namespace App\Service;

use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class AsyncService
{
    public const CREATE_CAR_REPORT = 'create_car_report';

    /**
     * @param ProducerInterface[] $producers
     */
    public function __construct(private array $producers = [])
    {
    }

    public function addProducer(string $producerName, ProducerInterface $producer): void
    {
        $this->producers[$producerName] = $producer;
    }

    public function publishToExchange(
        string  $producerName,
        string  $message,
        ?string $routingKey = null,
        ?array  $additionalProperties = null,
    ): bool {
        if (isset($this->producers[$producerName])) {
            $this->producers[$producerName]->publish($message, $routingKey ?? '', $additionalProperties ?? []);

            return true;
        }

        return false;
    }
}
