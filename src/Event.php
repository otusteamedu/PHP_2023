<?php

declare(strict_types=1);

namespace App;

class Event
{
    const SOURCES = [
        'планер' => 1,
        'силовая установка' => 2,
        'шасси' => 4,
        'тормозная система' => 8,
        'бортовое оборудование' => 16,
    ];

    private int $priority;
    private array $source;
    private array $payload;

    public function __construct(int $priority, array $source, array $payload)
    {
        $this->priority = $priority;
        $this->source = $source;
        $this->payload = $payload;
    }

    public function getSource(): array
    {
        return $this->source;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);
        $priority = $data['priority'] ?? 0;
        $source = $data['source'] ?? [];

        $payload = isset($data['payload']) ? json_decode($data['payload'], true) : [];
        if ($payload === null && json_last_error() !== JSON_ERROR_NONE) {
            $payload = [];
        }

        return new self($priority, $source, $payload);
    }
}
