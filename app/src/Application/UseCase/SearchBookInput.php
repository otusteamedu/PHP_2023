<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Application\UseCase;

interface SearchBookInput
{
    public function getTitle(): string;

    public function getCategory(): ?string;

    public function getPrice(): ?string;
}
