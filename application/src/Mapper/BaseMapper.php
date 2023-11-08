<?php

declare(strict_types=1);

namespace Gesparo\HW\Mapper;

use Gesparo\HW\AppException;
use Gesparo\HW\Entity\BaseEntity;
use Gesparo\HW\Entity\Film;
use Gesparo\HW\IdentityMap;

abstract class BaseMapper
{
    protected \PDO $pdo;

    protected \PDOStatement $selectStmt;
    protected \PDOStatement $insertStmt;
    protected \PDOStatement $updateStmt;
    protected \PDOStatement $deleteStmt;
    protected \PDOStatement $selectManyStmt;

    protected IdentityMap $identityMap;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->identityMap = new IdentityMap();

        $this->selectStmt = $this->getSelectStmt();
        $this->insertStmt = $this->getInsertStmt();
        $this->updateStmt = $this->getUpdateStmt();
        $this->deleteStmt = $this->getDeleteStmt();
        $this->selectManyStmt = $this->getSelectManyStmt();
    }

    abstract protected function getSelectStmt(): \PDOStatement;
    abstract protected function getInsertStmt(): \PDOStatement;
    abstract protected function getUpdateStmt(): \PDOStatement;
    abstract protected function getDeleteStmt(): \PDOStatement;
    abstract protected function getSelectManyStmt(): \PDOStatement;

    abstract protected function mapRowToEntity(int $id, array $row): BaseEntity;
    abstract protected function getInsertFields(array $raw): array;
    abstract protected function getUpdateFields(BaseEntity $entity): array;

    /**
     * @throws AppException
     */
    public function findById(int $id): ?BaseEntity
    {
        if ($film = $this->identityMap->get($id)) {
            return $film;
        }

        $isFetchModeSet = $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);

        if (!$isFetchModeSet) {
            throw AppException::cannotSetFetchModeInSelect();
        }

        $executeResult = $this->selectStmt->execute([$id]);

        if (!$executeResult) {
            throw AppException::executeSelectFailed($id);
        }

        $row = $this->selectStmt->fetch();

        if (!$row) {
            return null;
        }

        $result = $this->mapRowToEntity($id, $row);

        $this->identityMap->add($result);

        return $result;
    }

    /**
     * @throws AppException
     */
    public function findMany(array $ids): array
    {
        $films = [];
        $attachedIds = [];

        foreach ($ids as $id) {
            if ($film = $this->identityMap->get($id)) {
                $films[] = $film;
                $attachedIds[] = $id;
            }
        }

        $ids = array_diff($ids, $attachedIds);

        if (empty($ids)) {
            return $films;
        }

        $isFetchModeSet = $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);

        if (!$isFetchModeSet) {
            throw AppException::cannotSetFetchModeInSelect();
        }

        $executeResult = $this->selectStmt->execute(['ids' => $ids]);

        if (!$executeResult) {
            throw AppException::executeSelectManyFailed($ids);
        }

        $rows = $this->selectManyStmt->fetchAll();

        if (!$rows) {
            return [];
        }

        foreach ($rows as $row) {
            $films = $this->mapRowToEntity((int)$row['id'], $row);

            $this->identityMap->add($films);

            $films[] = $films;
        }

        return $films;
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function insert(array $raw): BaseEntity
    {
        $executeResult = $this->insertStmt->execute($this->getInsertFields($raw));

        if (!$executeResult) {
            throw AppException::executeInsertFailed($raw);
        }

        $result = $this->mapRowToEntity((int)$this->pdo->lastInsertId(), $raw);

        $this->identityMap->add($result);

        return $result;
    }

    /**
     * @throws AppException
     * @throws \JsonException
     */
    public function update(Film $film): void
    {
        $data = $this->getUpdateFields($film);
        $executeResult = $this->updateStmt->execute($data);

        if (!$executeResult) {
            throw AppException::executeUpdateFailed($data);
        }

        $this->identityMap->add($film);
    }

    /**
     * @throws AppException
     */
    public function delete(int $id): void
    {
        $executeResult = $this->deleteStmt->execute([$id]);

        if (!$executeResult) {
            throw AppException::executeDeleteFailed($id);
        }

        $this->identityMap->remove($id);
    }
}
