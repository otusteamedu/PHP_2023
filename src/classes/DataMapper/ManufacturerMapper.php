<?php

declare(strict_types = 1);

namespace Klobkovsky\App\DataMapper;

use Klobkovsky\App\DataMapper\Manufacturer;
use Klobkovsky\App\DataMapper\IdentityMap;

class ManufacturerMapper {
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var IdentityMap
     */
    private $identityMap;

    /**
     * @var \PDOStatement
     */
    private $selectStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->identityMap = new IdentityMap();

        $this->selectStmt = $pdo->prepare(
            "select parent_id, level, name, rusname, alias from auto_parents where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into auto_parents (parent_id, level, name, rusname, alias) values (?, ?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update auto_parents set parent_id = ?, level = ?, name = ?, rusname = ?, alias = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from auto_parents where id = ?");
    }

    /**
     * @param int $id
     *
     * @return Manufacturer
     */
    public function findById(int $id): Manufacturer
    {
        if ($this->identityMap->has($id)) {
            return $this->identityMap->get($id);
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $manufacturer = new Manufacturer(
            $id,
            (int)$result['parent_id'],
            (int)$result['level'],
            $result['name'],
            $result['rusname'],
            $result['alias']
        );

        $this->identityMap->set($id, $manufacturer);

        return $manufacturer;
    }

    /**
     * @param int $id
     *
     * @return Manufacturer
     */
    public function findByIds(array $ids): \ArrayObject
    {
        $arManufacturer = new \ArrayObject([]);

        foreach ($ids as $id) {
            $arManufacturer->append($this->findById($id));
        }

        return $arManufacturer;
    }

    /**
     * @param array $raw
     *
     * @return Manufacturer
     */
    public function insert(array $raw): Manufacturer
    {
        $this->insertStmt->execute([
            $raw['parent_id'],
            $raw['level'],
            $raw['name'],
            $raw['rusname'],
            $raw['alias']
        ]);

        return new Manufacturer(
            (int) $this->pdo->lastInsertId(),
            $raw['parent_id'],
            $raw['level'],
            $raw['name'],
            $raw['rusname'],
            $raw['alias']
        );
    }

    /**
     * @param Manufacturer $manufacturer
     *
     * @return bool
     */
    public function update(Manufacturer $manufacturer): bool
    {
        return $this->updateStmt->execute([
            $manufacturer->getParentId(),
            $manufacturer->getLevel(),
            $manufacturer->getName(),
            $manufacturer->getRusname(),
            $manufacturer->getAlias(),
            $manufacturer->getId(),
        ]);
    }

    /**
     * @param Manufacturer $manufacturer
     *
     * @return bool
     */
    public function delete(Manufacturer $manufacturer): bool
    {
        return $this->deleteStmt->execute([$manufacturer->getId()]);
    }
}