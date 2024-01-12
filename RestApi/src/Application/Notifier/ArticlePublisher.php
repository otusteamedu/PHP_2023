<?php

namespace App\Application\Notifier;

use App\Domain\Entity\Article;
use App\Domain\Entity\Category;

class ArticlePublisher implements NotifierInterface
{
    public function __construct(
        private array $subscribers = []
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

    public function notify(Category $articleCategory): void
    {
        $observerEmails = $this->subscribers[$articleCategory->getId()] ?? [];

        foreach ($observerEmails as $observerEmail) {
            echo "Subscriber with email {$observerEmail} notified successfully.";
        }
    }

    public function publishNews(Article $article): void
    {
        $categories = $article->getCategories();

        foreach ($categories as $category) {
            $this->notify($category);
        }
    }
}
