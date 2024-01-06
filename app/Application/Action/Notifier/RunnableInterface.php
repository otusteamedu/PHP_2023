<?php

namespace App\Application\Action\Notifier;

interface RunnableInterface
{
    public function run(string $content): void;
}
