<?php

namespace App\Application\Action\Notify;

interface NotifyInterface
{
    public function send(string $content): void;
}
