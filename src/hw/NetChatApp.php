<?php

namespace Ndybnov\Hw05\hw;

use Ndybnov\Hw05\hw\interface\NetworkApplicationInterface;

class NetChatApp
{
    private function __construct()
    {
    }

    public static function build(): self
    {
        return new self();
    }

    public function create(string $typeApp): NetworkApplicationInterface
    {
        return $this->createAppByType($typeApp);
    }

    private function createAppByType(string $type): NetworkApplicationInterface
    {
        $types = [
            'client' => NetAppClient::class,
            'server' => NetAppServer::class,
        ];
        return new ($types[$type] ?? NetAppNull::class)();
    }
}
