<?php

namespace App\Domains\Order\Domain\Factories\Order;

use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Entity\Order\OrderFromShop;
use App\Domains\Order\Domain\ValueObjects\ShopID;
use App\Domains\Order\Domain\ValueObjects\TableTentNumber;

class OrderShopFactory implements OrderFactoryInterface
{
    public function makeOrder(CreateOrderRequest $request): AbstractOrder
    {
        return new OrderFromShop(
            new ShopID($request->shopId),
            new TableTentNumber($request->tableTentNumber)
        );
    }
}
