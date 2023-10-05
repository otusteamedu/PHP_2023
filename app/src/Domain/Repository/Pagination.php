<?php

declare(strict_types=1);

namespace App\Domain\Repository;

final class Pagination
{
    public function __construct(
        private int $page,
        private readonly int $perPage,
        private ?int $count,
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function getCountPages(): ?int
    {
        if (null === $this->count) {
            return null;
        }

        return (int) ceil($this->count / $this->perPage);
    }

    public function getOffset(): int
    {
        return $this->page * $this->perPage - $this->perPage;
    }

    public function iteratePage(): void
    {
        $this->page++;
    }
}
