<?php

namespace IilyukDmitryi\App\Application\Dto;

class Event
{
    public function __construct(
        protected string $uuid,
        protected array $params,
        protected bool $done,
    ) {
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'params' => $this->getParams(),
            'done' => $this->isDone(),
        ];
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
    }
}