<?php
declare(strict_types=1);

interface Book
{
    public function open(): void;
    public function turnPage(): void;
    public function getPage(): int;
}

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

function clientCode(Book $book)
{
    $book->open();
    $book->turnPage();
    echo "Current page: " . $book->getPage();
}

$book = new EBookAdapter(new EBook());
clientCode($book);
