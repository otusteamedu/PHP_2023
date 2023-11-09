<?php

namespace src\inside;

use src\Exception\EmptyKeyForDataListException;
use src\Exception\GreetingNonexistentException;

class DataArray
{
    private array $dataArray;

    public static function build(): self
    {
        return new self();
    }

    public function toArray(): array
    {
        return $this->dataArray;
    }

    public function addByKey($key, $value): self
    {
        $this->dataArray[$key] = $value;
        return $this;
    }

    /**
     * @throws EmptyKeyForDataListException
     */
    public function addKeyWithValueIndexed(array $keyWithValue): self
    {
        if(!count($keyWithValue)) {
            throw new EmptyKeyForDataListException('Method '.__METHOD__.' got empty-array without key!');
        }
        $key = array_key_first($keyWithValue);
        $this->dataArray[ $key ] = $keyWithValue[$key];
        return $this;
    }

    public function hasByKey($key): bool
    {
        return array_key_exists($key, $this->dataArray);
    }

    public function getByKey($key)
    {
        return $this->dataArray[$key];
    }

    public function getByKeyWithDefault($key, $default)
    {
        return $this->dataArray[$key] ?? $default;
    }

    /**
     * @throws GreetingNonexistentException
     */
    public function getByKeyOrException($key)
    {
        return $this->dataArray[$key] ?? throw new GreetingNonexistentException('key::' . $key);
    }
}
