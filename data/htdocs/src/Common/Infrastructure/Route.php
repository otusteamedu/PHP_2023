<?php

namespace Common\Infrastructure;

class Route extends AbstractRoute
{
    public function __construct(string $path, string $name, private $handler, private readonly string $method)
    {
        parent::__construct($path, $name);
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
