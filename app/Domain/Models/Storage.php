<?php

declare(strict_types=1);

namespace App\Domain\Models;

abstract class Storage
{
    /**
     * @param array $params
     * @return mixed
     */
    abstract public function find(array $params): mixed;

    /**
     * @param Event $event
     * @return bool
     */
    abstract public function add(Event $event): bool;

    /**
     * @return void
     */
    abstract public function clear(): void;
}