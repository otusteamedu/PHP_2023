<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\AbstractFactory;

use Art\Php2023\Domain\AbstractFactory\Contract\BillInterface;

class Receipt implements BillInterface
{
    /**
     * @return void
     */
    public function getDescription(): void
    {
        echo 'I am a receipt bill - I can be together only with a Residential document';
    }
}
