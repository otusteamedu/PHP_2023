<?php
declare(strict_types=1);

namespace Decorator;

interface Notifier
{
    public function send(string $message): string;
}
