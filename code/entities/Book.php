<?php

/**
 * Класс книга
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

use Amedvedev\code\storages\Storage;

class Book
{
    protected string $index;
    protected string $id;
    protected string $title;
    protected string $sku;
    protected string $category;
    protected float $price;
    protected array $stock;

    /**
     * @throws \Exception
     */
    public function __construct(array $array)
    {
        if (empty($array['index']) || empty($array['title'])) {
            throw new \Exception('Ошибка создания Book: Название товара или индекс не переданы');
        }

        $this->setIndex($array['index']);
        $this->setId($array['id'] ?? 0);
        $this->setTitle($array['title']);
        $this->setSku($array['sku'] ?? '');
        $this->setCategory($array['category'] ?? '');
        $this->setPrice($array['price'] ?? 0);

        if (!empty($array['stock'])) {
            foreach ($array['stock'] as $stock)
                $this->addStock(new Stock($stock));
        }
    }

    /**
     * @param string $index
     */
    public function setIndex(string $index): void
    {
        $this->index = $index;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @param Stock $stock
     */
    public function addStock(Stock $stock): void
    {
        $this->stock[] = $stock->toArray();
    }

    /**
     * @param Storage $storage
     * @return bool
     */
    public function save(Storage $storage): bool
    {
        return $storage->save($this->toArray());
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'index' => $this->index,
            'id' => $this->id,
            'title' => $this->title,
            'sku' => $this->sku,
            'category' => $this->category,
            'price' => $this->price,
            'stock' => $this->stock,
        ];
    }
}
