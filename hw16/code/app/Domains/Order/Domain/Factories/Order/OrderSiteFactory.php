<?php

namespace App\Domains\Order\Domain\Factories\Order;

use App\Domains\Order\Application\Factories\Order\OrderFactoryInterface;
use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Entity\Order\OrderFromSite;
use App\Domains\Order\Domain\ValueObjects\Address;
use App\Domains\Order\Domain\ValueObjects\Email;
use App\Domains\Order\Domain\ValueObjects\ShopID;

class OrderSiteFactory implements OrderFactoryInterface
{
    public function makeOrder(CreateOrderRequest $request): AbstractOrder
    {
        return new OrderFromSite(
            new ShopID($request->shopId),
            new Email($request->phone),
            new Address($request->deliveryAddress)
        );
    }
}
