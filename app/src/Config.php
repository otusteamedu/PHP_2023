<?php

declare(strict_types=1);

namespace DmitryEsaulenko\Hw15;

class Config
{
    private array $data = [];

    public function set($name, $value): Config
    {
        $this->data[$name] = $value;
        return $this;
    }

    public function get($name)
    {
        return $this->data[$name];
    }
}
