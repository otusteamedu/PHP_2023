<?php

namespace Common\Infrastructure;

class Route extends AbstractRoute
{
    public function __construct(string $path, string $name, private $handler, private readonly string $method)
    {
        parent::__construct($path, $name);

//        if (!is_callable($handler)) {
//            throw new \InvalidArgumentException('Handler must be callable');
//        }
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
