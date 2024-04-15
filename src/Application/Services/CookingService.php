<?php

namespace Dmitry\Hw16\Application\Services;

use Dmitry\Hw16\Application\Publisher\PublisherInterface;
use Dmitry\Hw16\Domain\Entity\ProductInterface;

class CookingService implements CookingInterface
{

    private PublisherInterface $publisher;

    public function __construct(PublisherInterface $publisher)
    {
        $this->publisher = $publisher;
    }

    public function cook(ProductInterface $product): ProductInterface
    {
        $this->publisher->notify($product, 'Отправлен готовиться');
        $product->makeCooked();
        $this->publisher->notify($product, 'Приготовлен');
        return $product;
    }
}
