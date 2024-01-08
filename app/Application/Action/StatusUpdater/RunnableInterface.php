<?php

namespace App\Application\Action\StatusUpdater;

interface RunnableInterface
{
    public function run(string $content): void;
}
