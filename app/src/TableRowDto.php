<?php

declare(strict_types=1);

namespace Root\App;

class TableRowDto
{
    public ?float $score = null;
    public ?string $sku = null;
    public ?string $title = null;
    public ?string $category = null;
    public ?int $price = null;
    public array $stock = [];
}
