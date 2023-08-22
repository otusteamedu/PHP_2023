<?php

declare(strict_types=1);

namespace App\News\Domain\Notifier;

use App\News\Domain\Orm\Category;
use App\News\Domain\Orm\News;

class NewsSubject implements SubjectInterface
{
    public function __construct(
        private array $subscribers = [],
    ) {
    }

    public function observe(Category $category, string $observerEmail): void
    {
        $this->subscribers[$category->getId()][] = $observerEmail;
    }

    public function removeObserver(Category $category, string $observerEmail): void
    {
        unset($this->subscribers[$category->getId()][$observerEmail]);
    }

    public function notifyObservers(Category $newsCategory): void
    {
        $observerEmails = $this->subscribers[$newsCategory->getId()] ?? [];

        foreach ($observerEmails as $observerEmail) {
            fwrite(STDOUT, "Notify $observerEmail subscriber about new news");
        }
    }

    public function publishNews(News $news): void
    {
        $this->notifyObservers($news->getCategory());
    }
}
