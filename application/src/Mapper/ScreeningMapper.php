<?php

declare(strict_types=1);

namespace Gesparo\HW\Mapper;

use Gesparo\HW\AppException;
use Gesparo\HW\Entity\BaseEntity;
use Gesparo\HW\Entity\Screening;

class ScreeningMapper extends BaseMapper
{
    protected \PDOStatement $selectManyByFilmIdStmt;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);

        $this->selectManyByFilmIdStmt = $this->pdo->prepare('
            SELECT id, film_id, `date`, `time`, created_at, updated_at 
            FROM screenings 
            WHERE film_id = :film_id
            ORDER BY id DESC
        ');
    }

    /**
     * @throws AppException
     */
    public function findManyByFilmId(int $filmId): array
    {
        $isFetchModeSet = $this->selectManyByFilmIdStmt->setFetchMode(\PDO::FETCH_ASSOC);

        if (!$isFetchModeSet) {
            throw AppException::cannotSetFetchModeInSelect();
        }

        $executeResult = $this->selectManyByFilmIdStmt->execute(['film_id' => $filmId]);

        if (!$executeResult) {
            throw AppException::executeSelectFailed($filmId);
        }

        $rows = $this->selectManyByFilmIdStmt->fetchAll();

        if (empty($rows)) {
            return [];
        }

        $screenings = [];

        foreach ($rows as $row) {
            $screening = $this->mapRowToFilm((int)$row['id'], $row);

            $this->identityMap->add($screening);

            $screenings[] = $screening;
        }

        return $screenings;
    }

    protected function getSelectStmt(): \PDOStatement
    {
        return $this->pdo->prepare('SELECT film_id, `date`, `time`, created_at, updated_at FROM screenings WHERE id = :id');
    }

    protected function getInsertStmt(): \PDOStatement
    {
        return $this->pdo->prepare('
            INSERT INTO screenings (film_id, `date`, `time`, created_at, updated_at) 
            VALUES (:film_id, :date, :time, :created_at, :updated_at)
        ');
    }

    protected function getUpdateStmt(): \PDOStatement
    {
        return $this->pdo->prepare('
            UPDATE screenings 
            SET 
                film_id = :film_id, 
                `date` = :date, 
                `time` = :time, 
                created_at = :created_at, 
                updated_at = :updated_at 
            WHERE id = :id
            LIMIT 1
        ');
    }

    protected function getDeleteStmt(): \PDOStatement
    {
        return $this->pdo->prepare('DELETE FROM screenings WHERE id = ? LIMIT 1');
    }

    protected function getSelectManyStmt(): \PDOStatement
    {
        return $this->pdo->prepare('
            SELECT id, film_id, `date`, `time`, created_at, updated_at 
            FROM screenings 
            WHERE id IN (:ids)
            ORDER BY id DESC
        ');
    }


    protected function mapRowToFilm(int $id, array $row): BaseEntity
    {
        return new Screening(
            $id,
            (int)$row['film_id'],
            $row['date'],
            $row['time'],
            $row['created_at'],
            $row['updated_at']
        );
    }

    protected function getInsertFields(array $raw): array
    {
        return [
            'film_id' => $raw['film_id'],
            'date' => $raw['date'],
            'time' => $raw['time'],
            'created_at' => $raw['created_at'],
            'updated_at' => $raw['updated_at'],
        ];
    }

    protected function getUpdateFields(BaseEntity $entity): array
    {
        /** @var Screening $entity */
        return [
            'id' => $entity->getId(),
            'film_id' => $entity->getFilmId(),
            'date' => $entity->getDate(),
            'time' => $entity->getTime(),
            'created_at' => $entity->getCreatedAt(),
            'updated_at' => $entity->getUpdatedAt(),
        ];
    }
}
