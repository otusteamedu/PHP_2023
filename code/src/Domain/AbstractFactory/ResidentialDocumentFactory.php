<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\AbstractFactory;

use Art\Php2023\Domain\AbstractFactory\Contract\BillInterface;
use Art\Php2023\Domain\AbstractFactory\Contract\DocumentFactoryInterface;
use Art\Php2023\Domain\AbstractFactory\Contract\DocumentInterface;

class ResidentialDocumentFactory implements DocumentFactoryInterface
{
    /**
     * @return DocumentInterface
     */
    public function makeDocument(): DocumentInterface
    {
        return new ResidentialDocument();
    }

    /**
     * @return BillInterface
     */
    public function makeBill(): BillInterface
    {
        return new Receipt();
    }
}
