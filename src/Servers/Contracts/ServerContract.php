<?php

declare(strict_types=1);

namespace Twent\Chat\Servers\Contracts;

use Twent\Chat\Sockets\BaseSocketClient;
use Twent\Chat\Sockets\BaseSocketManager;

interface ServerContract
{
    public function __construct(BaseSocketManager|BaseSocketClient $socketManager);
    public function __clone(): void;
    public function __wakeup(): void;
    public static function getInstance(): ?ServerContract;
    public function run(): void;
}
