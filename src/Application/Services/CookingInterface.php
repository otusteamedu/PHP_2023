<?php

namespace Dmitry\Hw16\Application\Services;

use Dmitry\Hw16\Application\Publisher\PublisherInterface;
use Dmitry\Hw16\Domain\Entity\ProductInterface;

interface CookingInterface
{
    public function __construct(PublisherInterface $publisher);

    public function cook(ProductInterface $product): ProductInterface;
}