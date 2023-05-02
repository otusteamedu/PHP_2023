<?php

namespace Yakovgulyuta\Hw7\Chat;

abstract class SocketInstance implements Start
{
    protected \Socket $instance;
    protected array $config;

    public function __construct()
    {
        $this->instance = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    protected function write()
    {
    }

    protected function read()
    {
    }
}
