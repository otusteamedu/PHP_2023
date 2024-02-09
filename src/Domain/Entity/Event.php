<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Payload;
use App\Domain\ValueObject\Source;
use App\Domain\ValueObject\Priority;

class Event
{
    const SOURCES = [
        'планер' => 1,
        'силовая установка' => 2,
        'шасси' => 4,
        'тормозная система' => 8,
        'бортовое оборудование' => 16,
    ];

    private Priority $priority;
    private Source $source;
    private Payload $payload;

    public function __construct(Priority $priority, Source $source, Payload $payload)
    {
        $this->priority = $priority;
        $this->source = $source;
        $this->payload = $payload;
    }

    public function getSource(): Source
    {
        return $this->source;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function getPayload(): Payload
    {
        return $this->payload;
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        $priorityValue = $data['priority'] ?? 0;
        $sourceData = $data['source'] ?? [];
        $payloadData = isset($data['payload']) ? json_decode($data['payload'], true) : [];

        $priority = new Priority($priorityValue);
        $source = new Source(...$sourceData);
        $payload = new Payload(...$payloadData);

        if ($payloadData === null && json_last_error() !== JSON_ERROR_NONE) {
            $payload = new Payload([]);
        }

        return new self($priority, $source, $payload);
    }
}
