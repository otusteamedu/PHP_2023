<?php

declare(strict_types=1);

namespace App\Music\Domain\Entity;

class Track
{
    private string $name;
    private string $author;
    private int $duration;
    private Genre $genre;
}