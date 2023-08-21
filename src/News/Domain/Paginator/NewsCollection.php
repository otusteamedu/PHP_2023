<?php

declare(strict_types=1);

namespace App\News\Domain\Paginator;

use App\News\Domain\Orm\News;
use Traversable;

final readonly class NewsCollection implements \IteratorAggregate
{
    /**
     * @param News[] $news
     */
    public function __construct(
        private array $news,
    ) {
    }

    /**
     * @return Traversable<News>
     */
    public function getIterator(): Traversable
    {
        return new NewsIterator($this->news);
    }
}
