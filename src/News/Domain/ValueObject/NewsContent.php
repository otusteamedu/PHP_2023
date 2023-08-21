<?php

declare(strict_types=1);

namespace App\News\Domain\ValueObject;

final readonly class NewsContent
{
    private string $content;

    public function __construct(string $content)
    {
        assert(!empty($content));

        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
