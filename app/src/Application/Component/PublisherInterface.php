<?php

declare(strict_types=1);

namespace App\Application\Component;

interface PublisherInterface
{
    public function dispatch(object $command): void;
}
