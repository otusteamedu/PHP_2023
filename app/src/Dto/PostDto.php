<?php

declare(strict_types=1);

namespace App\Dto;

readonly class PostDto
{
    public function __construct(
        public string $title,
        public string $content,
        public string $createdBy,
        public int|null $id = null,
    ) {
    }
}
