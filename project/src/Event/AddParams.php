<?php

declare(strict_types=1);

namespace Vp\App\Event;

class AddParams
{
    private int $argc;
    private string $priority;
    private string $event;
    private array $params;

    public function __construct(int $argc)
    {
        $this->argc = $argc;
    }

    public function setParams(array $argv): static
    {
        $this->priority = $argv[2];
        $this->event = $argv[3];
        $this->params = $this->getPreparedParams($argv);
        return $this;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    private function getPreparedParams(array $argv): array
    {
        $params = [];
        for ($i = 4; $i < $this->argc; $i++) {
            $params[] = md5($argv[$i]);
        }
        return $params;
    }
}
