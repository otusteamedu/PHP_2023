<?php

declare(strict_types=1);

namespace Eevstifeev\Chat\Contracts;

interface SocketContract
{
    public function handle(): void;
}
