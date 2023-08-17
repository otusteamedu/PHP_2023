<?php

declare(strict_types=1);

namespace Root\App;

abstract class Product
{
    protected int $lettuce = 0;
    protected int $onion = 0;
    protected int $pepper = 0;

    protected string $name;

    public function __construct(int $lettuce, int $onion, int $pepper)
    {
        $this->lettuce = $lettuce;
        $this->onion = $onion;
        $this->pepper = $pepper;
    }

    public function getLettuce(): int
    {
        return $this->lettuce;
    }
    public function getOnion(): int
    {
        return $this->onion;
    }
    public function getPepper(): int
    {
        return $this->pepper;
    }

    public function getName(): string
    {
        return $this->name;
    }


}
