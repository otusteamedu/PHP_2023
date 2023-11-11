<?php

declare(strict_types=1);

namespace User\Php2023\Domain\Interfaces;

interface Observable
{
    public function attach(Observer $observer): void;

    public function notify(): void;
}
