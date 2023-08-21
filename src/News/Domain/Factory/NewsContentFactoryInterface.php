<?php

declare(strict_types=1);

namespace App\News\Domain\Factory;

use App\News\Domain\ValueObject\NewsContent;

interface NewsContentFactoryInterface
{
    public function create(string $text): NewsContent;
}
