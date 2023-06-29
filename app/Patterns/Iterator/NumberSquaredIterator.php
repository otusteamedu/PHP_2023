<?php
declare(strict_types=1);

namespace Iterator;

use Exception;
use Iterator;

class NumberSquaredIterator implements Iterator
{
    private Iterator $iterator;

    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    public function current()
    {
        $current = $this->iterator->current();
        if (is_numeric($current)) {
            return $current * $current;
        } else {
            throw new Exception('Non-numeric value encountered in NumberSquaredIterator');
        }
    }

    public function next()
    {
        $this->iterator->next();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    /**
     * @param Iterator $iterator
     */
    public function setIterator(Iterator $iterator): void
    {
        $this->iterator = $iterator;
    }
}
