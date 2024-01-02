<?php

namespace Gkarman\Otuselastic\Commands\Classes;

use Gkarman\Otuselastic\Dto\BookDto;

class SearchBooksCommand extends AbstractCommand
{
    public function run(): string
    {
        $books = $this->repository->searchBooks();
        $response = $this->dataToString($books);
        return $response;
    }

    private function dataToString(array $books): string
    {
        if (empty($books)) {
            return 'нет данных';
        }

        $str = ' Price / Category / Title / ' . "\n";
        foreach ($books as $book) {
            /** @var BookDto $book */
            $str .= "{$book->price} / {$book->category} / {$book->title}  \n";
        }
        return $str;
    }
}
