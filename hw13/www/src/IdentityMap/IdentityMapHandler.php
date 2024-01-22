<?php

namespace Shabanov\Otusphp\IdentityMap;

use RedisException;
use Shabanov\Otusphp\DataMapper\Product;

class IdentityMapHandler
{
    private \Redis $rClient;
    private const PREFIX = 'product';
    public function __construct(\Redis $rClient)
    {
        $this->rClient = $rClient;
    }

    /**
     * @throws RedisException
     */
    public function add(Product $product): void
    {
        $this->rClient->set(
            self::PREFIX . ':' . $product->getId(),
            serialize($product)
        );
    }

    /**
     * @throws RedisException
     */
    public function update(Product $product): void
    {
        $this->rClient->set(
            self::PREFIX . ':' . $product->getId(),
            serialize($product)
        );
    }

    /**
     * @throws RedisException
     */
    public function delete(Product $product): void
    {
        $this->rClient->del(self::PREFIX . ':' . $product->getId());
    }

    /**
     * @throws RedisException
     */
    public function getEntity(int $id): ?Product
    {
        $product = unserialize($this->rClient->get(self::PREFIX . ':' . $id));
        if (!empty($product)) {
            return $product;
        }
        return null;
    }
}
