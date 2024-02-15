<?php

namespace App\Domains\Order\Domain\Entity\Order;

use App\Domains\Order\Domain\ValueObjects\ShopID;
use App\Domains\Order\Domain\ValueObjects\TableTentNumber;

class OrderFromShop extends AbstractOrder
{
    public function __construct(
        protected ShopID  $shopId,
        protected TableTentNumber $tableTentNumber
    )
    {
    }
}
