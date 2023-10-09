<?php

/**
 * Склад
 * php version 8.2.8
 *
 * @category ItIsDepricated
 * @package  AmedvedevPHP2023Otus
 * @author   Alex 150Rus <alex150rus@outlook.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @Version  GIT: 1.0.0
 * @link     http://github.com/Alex150Rus My_GIT_profile
 */

declare(strict_types=1);

namespace Amedvedev\code\entities;

class Stock
{
    protected string $shop;
    protected int $stock;

    /**
     * @throws \Exception
     */
    public function __construct(array $array)
    {
        $this->shop = $array['shop'] ?? '';
        $this->stock= $array['stock'] ?? 0;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'shop' => $this->shop,
            'stock' => $this->stock,
        ];
    }
}
