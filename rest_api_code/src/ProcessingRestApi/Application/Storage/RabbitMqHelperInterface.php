<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\Storage;

interface RabbitMqHelperInterface
{
    public function addToQueue(string $queueName, string $message);
    public function readFromQueue(string $queueName);
}
