<?php

declare(strict_types=1);

namespace App\Application\Observer;

use App\Domain\Entity\News;

final class NewsIsCreatedEvent implements EventInterface
{
    public function __construct(
        private readonly News $news,
    ) {
    }

    public function getObject(): News
    {
        return $this->news;
    }
}
