<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Gesparo\HW\Mapper\BaseMapper;

class ModelRelation implements \IteratorAggregate
{
    protected ?\Traversable $iterator = null;
    protected BaseMapper $mapper;
    protected string $method;
    protected array $arguments;

    public function __construct(BaseMapper $mapper, string $method, array $arguments = [])
    {
        $this->mapper = $mapper;
        $this->method = $method;
        $this->arguments = $arguments;
    }

    public function getIterator(): \Traversable
    {
        if ($this->iterator === null) {
            $this->iterator = new \ArrayIterator(call_user_func_array([$this->mapper, $this->method], $this->arguments));
        }

        return $this->iterator;
    }

    /**
     * @throws \Exception
     */
    public function __call($name, array $arguments)
    {
        return new \ArrayIterator(call_user_func_array(array($this->getIterator(), $name), $arguments));
    }
}
