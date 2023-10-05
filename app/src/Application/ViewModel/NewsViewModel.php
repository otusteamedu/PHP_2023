<?php

declare(strict_types=1);

namespace App\Application\ViewModel;

final class NewsViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $authorId,
        public readonly string $categoryId,
        public readonly string $title,
        public readonly string $content,
        public readonly string $createdAt,
    ) {
    }
}
