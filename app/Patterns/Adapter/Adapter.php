<?php
declare(strict_types=1);

use Adapter\Book;
use Adapter\EBook;
use Adapter\EBookAdapter;

function clientCode(Book $book)
{
    $book->open();
    $book->turnPage();
    echo "Current page: " . $book->getPage();
}

$book = new EBookAdapter(new EBook());
clientCode($book);
