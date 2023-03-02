<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Components;

final class DockerContainer
{
    public function __construct(
        private readonly string $id,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
