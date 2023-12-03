<?php

namespace Radovinetch\Chat\Command;

use Radovinetch\Chat\Utils;

abstract class Command
{
    protected string $name;

    public function __construct(
       protected Utils $utils
    ) {}

    abstract public function execute(array $args): void;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}