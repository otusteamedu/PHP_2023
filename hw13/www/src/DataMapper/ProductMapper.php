<?php

namespace Shabanov\Otusphp\DataMapper;

use RedisException;
use Shabanov\Otusphp\UnitOfWork\UnitOfWorkHandler;

class ProductMapper
{
    private \PDO $pdoClient;
    private UnitOfWorkHandler $unitOfWork;
    private \PDOStatement $selectStatement;
    private \PDOStatement $selectAllStatement;
    private \PDOStatement $insertStatement;
    private \PDOStatement $updateStatement;
    private \PDOStatement $deleteStatement;
    public function __construct(\PDO $pdoClient, UnitOfWorkHandler $unitOfWork)
    {
        $this->pdoClient = $pdoClient;
        $this->unitOfWork = $unitOfWork;

        $this->selectStatement = $this->pdoClient->prepare(
            'SELECT * FROM products WHERE id = ?'
        );
        $this->selectAllStatement = $this->pdoClient->prepare(
            'SELECT * FROM products'
        );
        $this->insertStatement = $this->pdoClient->prepare(
            'INSERT INTO products(title, description, color, volume, price) VALUES (?, ?, ?, ?, ?)'
        );
        $this->updateStatement = $this->pdoClient->prepare(
            'UPDATE products SET title=?, description=?, color=?, volume=?, price=? WHERE id = ?'
        );
        $this->deleteStatement = $this->pdoClient->prepare(
            'DELETE FROM products WHERE id = ?'
        );
    }

    /**
     * @throws RedisException
     */
    public function getById(int $id): ?Product
    {
        $product = $this->unitOfWork->getEntity($id);
        if (empty($product)) {
            $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
            $this->selectStatement->execute([$id]);
            $result = $this->selectStatement->fetch();

            if (!empty($result)) {
                $product = new Product(
                    $result['id'],
                    $result['title'],
                    $result['description'],
                    $result['color'],
                    $result['volume'],
                    $result['price']
                );
            }
        }
        return $product;
    }

    /**
     * @throws RedisException
     */
    public function insert(array $rawUserData): Product
    {
        $this->insertStatement->execute([
            $rawUserData['title'],
            $rawUserData['description'],
            $rawUserData['color'],
            $rawUserData['volume'],
            $rawUserData['price']
        ]);

        $product = new Product(
            (int)$this->pdoClient->lastInsertId(),
            $rawUserData['title'],
            $rawUserData['description'],
            $rawUserData['color'],
            $rawUserData['volume'],
            $rawUserData['price']
        );

        $this->unitOfWork->add($product);

        return $product;
    }

    /**
     * @throws RedisException
     */
    public function update(Product $product): bool
    {
        $this->unitOfWork->update($product);

        return $this->updateStatement->execute([
            $product->getTitle(),
            $product->getDescription(),
            $product->getColor(),
            $product->getVolume(),
            $product->getPrice(),
            $product->getId(),
        ]);
    }

    /**
     * @throws RedisException
     */
    public function delete(Product $product): bool
    {
        $this->unitOfWork->delete($product);
        return $this->deleteStatement->execute([
            $product->getId()
        ]);
    }

    /**
     * @throws RedisException
     */
    public function getAll(): ProductCollection
    {
        $pc = new ProductCollection();
        $this->selectAllStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute();
        while($row = $this->selectAllStatement->fetch()) {
            $product = (new Product(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['color'],
                $row['volume'],
                $row['price']
            ));
            $pc->add($product);
            $this->unitOfWork->add($product);
        }
        return $pc;
    }
}
