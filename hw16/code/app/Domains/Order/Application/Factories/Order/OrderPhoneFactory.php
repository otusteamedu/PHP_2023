<?php

namespace App\Domains\Order\Application\Factories\Order;

use App\Domains\Order\Application\Requests\CreateOrderRequest;
use App\Domains\Order\Domain\Entity\Order\AbstractOrder;
use App\Domains\Order\Domain\Entity\Order\OrderFromPhone;
use App\Domains\Order\Domain\ValueObjects\Address;
use App\Domains\Order\Domain\ValueObjects\Phone;
use App\Domains\Order\Domain\ValueObjects\ShopID;

class OrderPhoneFactory implements OrderFactoryInterface
{
    public function makeOrder(CreateOrderRequest $request): AbstractOrder
    {
        return new OrderFromPhone(
            new ShopID($request->shopId),
            new Phone($request->phone),
            new Address($request->deliveryAddress)
        );
    }
}
