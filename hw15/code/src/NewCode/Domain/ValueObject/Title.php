<?php

namespace GKarman\CleanCode\NewCode\Domain\ValueObject;

use http\Exception\InvalidArgumentException;

class Title
{
    private string $title;

    /**
     * @throws \Exception
     */
    public function __construct(string $title)
    {
        $this->assertValidTitle($title);
        $this->title = $title;
    }

    private function assertValidTitle(string $title): void
    {
        if (mb_strlen($title) < 2) {
            throw new InvalidArgumentException('Заголовок должен быть более 2 букв');
        }
    }

    public function getValue(): string
    {
        return $this->title;
    }

    public function __toString(): string
    {
        return $this->title;
    }
}
