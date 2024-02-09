<?php

namespace App\Domain\ValueObject;


class Source
{
    private array $sources;

    public function __construct(array $sources)
    {
        $this->validate($sources);
        $this->sources = $sources;
    }

    private function validate(array $sources): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Sources array cannot be empty");
        }
    }

    public function getSources(): array
    {
        return $this->sources;
    }
}