<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Application\Repository;

use Imitronov\Hw11\Domain\Entity\Product;
use Imitronov\Hw11\Domain\Exception\ExternalServerException;

interface ProductRepository
{
    /**
     * @return Product[]
     * @throws ExternalServerException
     */
    public function allByTitleAndCategoryAndPriceInStock(
        string $name,
        ?string $category,
        ?string $price,
    ): array;
}
