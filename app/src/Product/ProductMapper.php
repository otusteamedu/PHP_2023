<?php

declare(strict_types=1);

namespace DEsaulenko\Hw13\Product;

use PDO;
use PDOStatement;

class ProductMapper
{
    public const TABLE_NAME = 'product';
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
    private $selectAllStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $tableName = self::TABLE_NAME;

        $this->selectStatement = $pdo->prepare(
            "select name, description, price, category from {$tableName} where id = ?"
        );
        $this->insertStatement = $pdo->prepare(
            "insert into {$tableName} (name, description, price, category) values (?, ?, ?, ?)"
        );
        $this->updateStatement = $pdo->prepare(
            "update {$tableName} set name = ?, description = ?, price = ?, category = ? where id = ?"
        );
        $this->deleteStatement = $pdo->prepare(
            "delete from {$tableName} where id = ?"
        );
        $this->selectAllStatement = $pdo->prepare(
            "select id, name, description, price, category from {$tableName}"
        );
    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function findById(int $id): Product
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        return new Product(
            $id,
            $result['name'],
            $result['description'],
            $result['price'],
            $result['category']
        );
    }

    /**
     * @return ProductCollection
     */
    public function findAll(): ProductCollection
    {
        $this->selectAllStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute();
        $result = $this->selectAllStatement->fetchAll();

        $collection = new ProductCollection();
        foreach ($result as $item) {
            $collection->addItem(new Product(
                $item['id'],
                $item['name'],
                $item['description'],
                $item['price'],
                $item['category']
            ));
        }

        return $collection;
    }

    /**
     * @param array $data
     *
     * @return Product
     */
    public function insert(array $data): Product
    {
        $this->insertStatement->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category']
        ]);

        return new Product(
            (int)$this->pdo->lastInsertId(),
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category'],
        );
    }

    /**
     * @param Product $product
     *
     * @return bool
     */
    public function update(Product $product): bool
    {
        return $this->updateStatement->execute([
            $product->getName(),
            $product->getDescription(),
            $product->getPrice(),
            $product->getCategory(),
            $product->getId()
        ]);
    }

    /**
     * @param Product $product
     *
     * @return bool
     */
    public function delete(Product $product): bool
    {
        return $this->deleteStatement->execute([
            $product->getId()
        ]);
    }
}
