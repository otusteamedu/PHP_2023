<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Dto;

class DataHandlerResponse
{
    public function __construct(public string $sku,
                                public string $title,
                                public string $category,
                                public float $price,
                                public string $shop,
                                public int $stock,
    ) {}
}
