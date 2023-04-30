<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Application\UseCase;

use Imitronov\Hw11\Application\Repository\ProductRepository;
use Imitronov\Hw11\Domain\Entity\Product;
use Imitronov\Hw11\Domain\Exception\ExternalServerException;

final class SearchProduct
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * @return Product[]
     * @throws ExternalServerException
     */
    public function handle(SearchProductInput $input): array
    {
        return $this->productRepository->allByTitleAndCategoryAndPriceInStock(
            $input->getTitle(),
            $input->getCategory(),
            $input->getPrice(),
        );
    }
}
