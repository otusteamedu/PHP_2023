<?php

declare(strict_types=1);

namespace Art\Code\Domain\Model;

abstract class Storage
{
    /**
     * @param array $params
     * @return mixed
     */
    abstract function find(array $params): mixed;

    /**
     * @param Event $event
     * @return bool
     */
    abstract function add(Event $event): bool;

    /**
     * @return void
     */
    abstract function clear(): void;
}
