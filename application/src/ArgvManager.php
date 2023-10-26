<?php

declare(strict_types=1);

namespace Gesparo\ES;

class ArgvManager
{
    private static ArgvManager $instance;
    private array $argv;

    private function __construct(array $argv)
    {
        $this->argv = $argv;
    }

    public static function initInstance(array $argv): void
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($argv);
        }
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }

    public function getByPosition(int $position): ?string
    {
        return $this->argv[$position] ?? null;
    }
}