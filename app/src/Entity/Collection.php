<?php

declare(strict_types=1);

namespace App\Entity;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class Collection implements IteratorAggregate
{
    /** @var EntityObject[] */
    private array $list = [];

    public function add(EntityObject $object): void
    {
        $this->list[] = $object;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }
}
