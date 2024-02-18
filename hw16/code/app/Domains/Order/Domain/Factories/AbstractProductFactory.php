<?php

namespace App\Domains\Order\Domain\Factories;

use App\Domains\Order\Application\Requests\AddProductToOrderRequest;
use App\Domains\Order\Domain\Entity\Product\AbstractProduct;
use App\Domains\Order\Domain\Repositories\ProductRepositoryInterface;

abstract class AbstractProductFactory
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ){

    }

    public abstract function make(AddProductToOrderRequest $request): AbstractProduct;
}
