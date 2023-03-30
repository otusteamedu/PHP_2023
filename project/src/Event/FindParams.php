<?php

declare(strict_types=1);

namespace Vp\App\Event;

class FindParams
{
    private int $argc;
    private array $params;

    public function __construct(int $argc)
    {
        $this->argc = $argc;
    }

    public function setParams(array $argv): static
    {
        $this->params = $this->getPreparedParams($argv);
        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    private function getPreparedParams(array $argv): array
    {
        $params = [];
        for ($i = 2; $i < $this->argc; $i++) {
            $params[] = md5($argv[$i]);
        }
        return $params;
    }
}
