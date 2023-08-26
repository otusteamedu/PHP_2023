<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\AbstractFactory;

use Art\Php2023\Domain\AbstractFactory\Contract\BillInterface;
use Art\Php2023\Domain\AbstractFactory\Contract\DocumentFactoryInterface;
use Art\Php2023\Domain\AbstractFactory\Contract\DocumentInterface;

class CommercialDocumentFactory implements DocumentFactoryInterface
{
    /**
     * @return DocumentInterface
     */
    public function makeDocument(): DocumentInterface
    {
        return new CommercialDocument();
    }

    /**
     * @return BillInterface
     */
    public function makeBill(): BillInterface
    {
        return new Invoice();
    }
}