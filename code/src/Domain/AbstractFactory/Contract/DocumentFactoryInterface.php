<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\AbstractFactory\Contract;

use Art\Php2023\Domain\AbstractFactory\Contract\BillInterface;
use Art\Php2023\Domain\AbstractFactory\Contract\DocumentInterface;

interface DocumentFactoryInterface
{
    public function makeDocument(): DocumentInterface;
    public function makeBill(): BillInterface;
}
