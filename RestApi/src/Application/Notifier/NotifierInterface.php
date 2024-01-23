<?php

namespace App\Application\Notifier;

use App\Domain\Entity\Category;

interface NotifierInterface
{
    public function subscribe(Category $category, string $observerEmail): void;
    public function unsubscribe(Category $category, string $observerEmail): void;
}
