<?php

declare(strict_types=1);

namespace Twent\Chat\Core;

interface Config
{
    public function __construct();
    public function get(string $key): ?string;
    public function has(string $key): bool;
}
