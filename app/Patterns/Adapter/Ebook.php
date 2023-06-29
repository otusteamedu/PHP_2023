<?php
declare(strict_types=1);

namespace Adapter;

class EBook
{
    private $page = 1;
    private $totalPages = 100;

    public function unlock(): void
    {
        $this->page = 1;
    }

    public function pressNext(): void
    {
        $this->page++;
    }

    public function getPage(): array
    {
        return [$this->page, $this->totalPages];
    }
}