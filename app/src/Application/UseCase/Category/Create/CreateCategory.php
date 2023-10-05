<?php

declare(strict_types=1);

namespace App\Application\UseCase\Category\Create;

use App\Domain\Entity\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\Flusher;
use App\Domain\Repository\Persister;

final class CreateCategory
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly Persister $persister,
        private readonly Flusher $flusher,
    ) {
    }

    public function handle(CreateCategoryInput $input): Category
    {
        $category = new Category(
            $this->categoryRepository->nextId(),
            $input->getName(),
        );
        $this->persister->persist($category);
        $this->flusher->flush();

        return $category;
    }
}
