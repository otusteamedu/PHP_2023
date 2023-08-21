<?php

declare(strict_types=1);

namespace App\News\Domain\Notifier;

use App\News\Domain\Orm\Category;

interface SubjectInterface
{
    public function observe(Category $category, string $observerEmail): void;

    public function removeObserver(Category $category, string $observerEmail): void;

    public function notifyObservers(Category $newsCategory): void;
}
