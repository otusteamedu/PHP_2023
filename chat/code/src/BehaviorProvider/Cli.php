<?php

namespace IilyukDmitryi\App\BehaviorProvider;

use InvalidArgumentException;

class Cli implements BehaviorProvider
{
    private bool $isServer = false;
    private bool $isClient = false;

    public function __construct()
    {
        $this->makeActions();
    }

    /**
     * @return string
     */
    public function makeActions(): void
    {
        $argv = $_SERVER['argv'];
        $type = $argv[1] ?? '';
        if (empty($type)) {
            throw new InvalidArgumentException('Empty command type actions');
        }
        if ('server' === $type) {
            $this->isServer = true;
        } elseif ('client' === $type) {
            $this->isClient = true;
        } else {
            throw new InvalidArgumentException('Unknown command type actions');
        }
    }

    /**
     * @return bool
     */
    public function isServer(): bool
    {
        return $this->isServer;
    }

    /**
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->isClient;
    }
}
