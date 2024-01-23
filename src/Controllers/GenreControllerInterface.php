<?php

declare(strict_types=1);

namespace App\Controllers;

interface GenreControllerInterface
{
    public function getAllGenres(): void;

    public function getOneById(int $id): void;

    public function insert(): void;

    public function update(): void;

    public function delete(): void;
}
