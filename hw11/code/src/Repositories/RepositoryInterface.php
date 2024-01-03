<?php

namespace Gkarman\Otuselastic\Repositories;

interface RepositoryInterface
{
    public function createDB(): string;

    public function importDB(): string;

    public function deleteDB(): string;

    public function searchBooks(): array;
}
