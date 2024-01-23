<?php

namespace App\Application\Notifier;

use App\Application\Strategy\StrategyInterface;
use App\Domain\Entity\Article;
use App\Domain\Entity\Category;

class ArticlePublisher implements NotifierInterface
{
    public function __construct(
        private readonly StrategyInterface $strategy,
        private array $subscribers = [],
    ) {
    }

    public function subscribe(Category $category, string $observerEmail): void
    {
        $this->subscribers[$category->getId()][] = $observerEmail;
    }

    public function unsubscribe(Category $category, string $observerEmail): void
    {
        unset($this->subscribers[$category->getId()][$observerEmail]);
    }

    public function publishNews(Article $article): void
    {
        $categories = $article->getCategories();

        foreach ($categories as $category) {
            $this->strategy->notify($category);
        }
    }
}
