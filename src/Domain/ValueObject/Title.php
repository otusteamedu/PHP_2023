<?php

namespace Dimal\Hw11\Domain\ValueObject;

class Title
{
    private ?string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
