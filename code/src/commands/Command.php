<?php

namespace Radovinetch\Hw11\commands;

use Radovinetch\Hw11\Storage;

abstract class Command
{
    public function __construct(protected Storage $storage)
    {
    }

    abstract public function run(array $options): void;
}