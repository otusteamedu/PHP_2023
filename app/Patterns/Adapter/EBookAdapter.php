<?php
declare(strict_types=1);

namespace Adapter;

// The Adapter
class EBookAdapter implements Book
{
    protected $eBook;

    public function __construct(EBook $eBook)
    {
        $this->eBook = $eBook;
        $this->eBook->unlock();
    }

    public function open(): void
    {
    }

    public function turnPage(): void
    {
        $this->eBook->pressNext();
    }

    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}
