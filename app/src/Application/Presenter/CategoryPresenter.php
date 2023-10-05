<?php

declare(strict_types=1);

namespace App\Application\Presenter;

use App\Application\ViewModel\CategoryViewModel;
use App\Domain\Entity\Category;

final class CategoryPresenter
{
    public function __construct(
        private readonly IdPresenter $idPresenter,
        private readonly NotEmptyStringPresenter $notEmptyStringPresenter,
    ) {
    }

    public function present(Category $category): CategoryViewModel
    {
        return new CategoryViewModel(
            $this->idPresenter->present($category->getId()),
            $this->notEmptyStringPresenter->present($category->getName()),
        );
    }
}
