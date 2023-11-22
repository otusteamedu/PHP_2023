<?php

namespace src\domain;

class DataCollection
{
    private array $data;

    public function __construct(array $data)
    {
        $this->setData($data);
    }

    public function count(): int
    {
        return \count($this->data);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
