<?php

declare(strict_types=1);

namespace App\Application\Decorator\Content;

use App\Domain\ValueObject\Content;

class ContentDecorator implements Content
{
    public function __construct(
        protected readonly Content $content,
    ) {
    }

    public function getValue(): string
    {
        return $this->content->getValue();
    }
}
