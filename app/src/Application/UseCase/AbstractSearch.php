<?php

namespace App\Application\UseCase;

use App\Domain\Repository\BookRepositoryInterface;

abstract class AbstractSearch
{
    protected BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
}
