<?php

declare(strict_types=1);

namespace App\Application\Middleware;

interface RequestInterface
{
    public function getClientIp(): ?string;
}
