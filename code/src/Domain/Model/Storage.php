<?php

declare(strict_types=1);

namespace Art\Code\Domain\Model;

abstract class Storage
{
    abstract function find(array $params): mixed;

    abstract function add(Event $event): bool;

    abstract function clear(): void;
}
