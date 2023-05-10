<?php

declare(strict_types=1);

namespace Imitronov\Hw11\Infrastructure\Component\Transformer;

use Imitronov\Hw11\Domain\ValueObject\Stock;

final class StockTransformer
{
    public function transform(array $raw): Stock
    {
        return new Stock(
            $raw['shop'],
            $raw['stock'],
        );
    }
}
