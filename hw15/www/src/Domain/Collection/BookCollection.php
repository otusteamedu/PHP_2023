<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Domain\Collection;
use Shabanov\Otusphp\Domain\Entity\Book;
use Traversable;

class BookCollection implements \IteratorAggregate, \Countable
{
    public function __construct(private ?array $books) {}

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->books);
    }

    public function count(): int
    {
        return count($this->books);
    }
}
