<?php

declare(strict_types=1);

namespace Root\App;

abstract class ProductBuilderAbstract
{
    protected int $lettuce = 0;
    protected int $onion = 0;
    protected int $pepper = 0;
    public function addLettuce(int $n = 1): self
    {
        $this->lettuce = $n;
        return $this;
    }
    public function addOnion(int $n = 1): self
    {
        $this->onion = $n;
        return $this;
    }
    public function addPepper(int $n = 1): self
    {
        $this->pepper = $n;
        return $this;
    }

    abstract public function build(): Product;
}
