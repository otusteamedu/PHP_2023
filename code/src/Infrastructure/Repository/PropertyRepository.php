<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Repository;

use Art\Php2023\Domain\Property;
use Art\Php2023\Domain\PropertyCollection;
use Art\Php2023\Domain\PropertyIdentityMap;
use PDO;

class PropertyRepository extends DataMapperPrototype
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'property';
    }

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);

        $this->selectStatement = $connection->prepare(
            sprintf('select * from %s where id = ?', self::getTableName())
        );

        $this->insertStatement = $connection->prepare(
            sprintf('insert into %s (name) values (?)', self::getTableName())
        );

        $this->updateStatement = $connection->prepare(
            sprintf('update %s set name = ? where id = ?', self::getTableName())
        );

        $this->deleteStatement = $connection->prepare(
            sprintf('delete from %s where id = ?', self::getTableName())
        );

        $this->findAllStatement = $connection->prepare(
            sprintf('select * from %s', self::getTableName())
        );
    }

    /**
     * @param bool $needCadastralInfo
     * @param int $id
     * @return PropertyCollection|PropertyIdentityMap
     */
    public function getPropertyById(int $id, bool $needCadastralInfo = false): PropertyCollection|PropertyIdentityMap
    {
        // use Identity Map
        $property = PropertyIdentityMap::getProperty($id);

        if ($property !== null) {
            return $property;
        }
        //

        $this->selectStatement->execute([$id]);

        $gotProperty = $this->selectStatement->fetch();

        if($needCadastralInfo){
            $gotProperty->getCadastralInformation();
        }

        PropertyIdentityMap::addProperty($gotProperty);

        return $gotProperty;
    }

    /**
     * @return PropertyCollection|PropertyIdentityMap
     */
    public function findAll(): PropertyCollection|PropertyIdentityMap
    {
        // use Identity Map
        $estates = PropertyIdentityMap::getAllEstates();

        if ($estates !== []) {
            return $estates;
        }
        //

        $this->findAllStatement->execute();

        $collection = new PropertyCollection();

        foreach ($this->findAllStatement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $collection->add(new Property(
                $row['id'],
                $row['name'],
                $row['type']
            ));

            PropertyIdentityMap::addProperty($row);
        }

        return $collection;
    }

    /**
     * @param Property $property
     * @return bool
     */
    public function update(Property $property): bool
    {
        return $this->updateStatement->execute([
            $property->getType(),
            $property->getName(),
            $property->getId()
        ]);
    }

    /**
     * @param Property $property
     * @return Property|null
     */
    public function insert(Property $property): ?Property
    {
        if (!$this->insertStatement->execute([$property->getType()])) {
            return null;
        }

        return $property->setId((int)$this->pdo->lastInsertId());
    }

    /**
     * @param Property $property
     * @return bool
     */
    public function delete(Property $property): bool
    {
        return $this->deleteStatement->execute([$property->getId()]);
    }
}