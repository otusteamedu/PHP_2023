<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Infrastructure\Cli;

use Imitronov\Hw11\Application\UseCase\SearchProductInput;

final class CliSearchProductInput implements SearchProductInput
{
    public function __construct(
        private readonly string $title,
        private readonly ?string $category,
        private readonly ?string $price,
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }
}
