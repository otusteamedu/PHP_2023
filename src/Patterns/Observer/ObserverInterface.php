<?php

declare(strict_types=1);

namespace Patterns\Daniel\Patterns\Observer;

interface ObserverInterface
{
    public function update(string $event, $data = null): void;
}