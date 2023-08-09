<?php

declare(strict_types=1);

namespace DEsaulenko\Hw13\DiscountPrice;

use DEsaulenko\Hw13\Product\Product;
use DEsaulenko\Hw13\Product\ProductCollection;
use PDO;
use PDOStatement;

class DiscountPrice
{
    public const TABLE_NAME = 'discount_price';
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var PDOStatement
     */
    private $selectStatement;

    /**
     * @var PDOStatement
     */
    private $insertStatement;

    /**
     * @var PDOStatement
     */
    private $updateStatement;

    /**
     * @var PDOStatement
     */
    private $deleteStatement;

    /**
     * @var PDOStatement
     */
    private $selectByProductIdStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $tableName = self::TABLE_NAME;

        $this->selectStatement = $pdo->prepare(
            "select product_id, discount_price from {$tableName} where id = ?"
        );
        $this->insertStatement = $pdo->prepare(
            "insert into {$tableName} (product_id, discount_price) values (?, ?)"
        );
        $this->updateStatement = $pdo->prepare(
            "update {$tableName} set product_id = ?, discount_price = ? where id = ?"
        );
        $this->deleteStatement = $pdo->prepare(
            "delete from {$tableName} where id = ?"
        );
        $this->selectByProductIdStatement = $pdo->prepare(
            "select id, discount_price from {$tableName} where product_id = ?"
        );
    }

    /**
     * @param int $id
     *
     * @return DiscountPriceDto
     */
    public function findById(int $id): DiscountPriceDto
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        return new DiscountPriceDto(
            $id,
            $result['product_id'],
            $result['discount_price'],
        );
    }

    /**
     * @param int $productId
     *
     * @return DiscountPriceDto|null
     */
    public function findByProductId(int $productId): ?DiscountPriceDto
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectByProductIdStatement->execute([$productId]);
        $result = $this->selectByProductIdStatement->fetch();

        if (!$result) {
            return null;
        }

        return new DiscountPriceDto(
            $result['id'],
            $productId,
            $result['discount_price'],
        );
    }

    /**
     * @param array $data
     *
     * @return DiscountPriceDto
     */
    public function insert(array $data): DiscountPriceDto
    {
        $this->insertStatement->execute([
            $data['product_id'],
            $data['discount_price']
        ]);

        return new DiscountPriceDto(
            (int)$this->pdo->lastInsertId(),
            (int)$data['product_id'],
            (float)$data['discount_price']
        );
    }

    /**
     * @param DiscountPriceDto $dto
     *
     * @return bool
     */
    public function update(DiscountPriceDto $dto): bool
    {
        return $this->updateStatement->execute([
            $dto->getId(),
            $dto->getProductId(),
            $dto->getDiscountPrice()
        ]);
    }

    /**
     * @param DiscountPriceDto $dto
     *
     * @return bool
     */
    public function delete(DiscountPriceDto $dto): bool
    {
        return $this->deleteStatement->execute([
            $dto->getId()
        ]);
    }
}
