<?php

declare(strict_types=1);

namespace Root\App\Application;

use JsonSerializable;

interface QueryInterface
{
    public function publish(string|JsonSerializable $message): void;
    public function listen(string $tag, callable $callback): void;
}
