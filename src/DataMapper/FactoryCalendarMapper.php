<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\IdentityMap\IdentityMap;

class FactoryCalendarMapper
{
    private \PDOStatement $selectStmt;

    private \PDOStatement $insertStmt;

    private \PDOStatement $updateStmt;

    private \PDOStatement $deleteStmt;

    private IdentityMap $identityMap;

    public function __construct(
        private readonly \PDO $pdo
    ) {
        $this->selectStmt = $this->pdo->prepare(
            "select date, work_hours, calendar_days, work_days, weekend_holidays_days, created_at, updated_at from factory_calendar where id = ?"
        );
        $this->insertStmt = $this->pdo->prepare(
            "insert into factory_calendar (date, work_hours, calendar_days, work_days, weekend_holidays_days, created_at, updated_at) values (?, ?, ?, ?, ?, ?, ?)"
        );
        $this->updateStmt = $this->pdo->prepare(
            "update factory_calendar set date = ?, work_hours = ?, calendar_days = ?, work_days = ?, weekend_holidays_days = ? , created_at = ?, updated_at = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from factory_calendar where id = ?");

        $this->identityMap = new IdentityMap();
    }

    public function findById(int $id): FactoryCalendar
    {
        $key = get_class(new FactoryCalendar()) . $id;
        $identityMapFactoryCalendar = $this->identityMap->getByKey($key);

        if ($identityMapFactoryCalendar !== null) {
            return $identityMapFactoryCalendar;
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $factoryCalendar = new FactoryCalendar(
            $id,
            $result['date'],
            $result['work_hours'],
            $result['calendar_days'],
            $result['work_days'],
            $result['weekend_holidays_days'],
            $result['created_at'],
            $result['updated_at'],
        );

        $this->identityMap->addObject($factoryCalendar);

        return $factoryCalendar;
    }

    public function insert(array $raw): FactoryCalendar
    {
        $this->insertStmt->execute([
            $raw['date'],
            $raw['work_hours'],
            $raw['calendar_days'],
            $raw['work_days'],
            $raw['weekend_holidays_days'],
            $raw['created_at'],
            $raw['updated_at'],
        ]);

        $factoryCalendar = new FactoryCalendar(
            (int) $this->pdo->lastInsertId(),
            $raw['date'],
            $raw['work_hours'],
            $raw['calendar_days'],
            $raw['work_days'],
            $raw['weekend_holidays_days'],
            $raw['created_at'],
            $raw['updated_at'],
        );

        $this->identityMap->addObject($factoryCalendar);

        return $factoryCalendar;
    }

    public function update(FactoryCalendar $factoryCalendar): bool
    {
        $this->identityMap->addObject($factoryCalendar);

        return $this->updateStmt->execute([
            $factoryCalendar->getDate(),
            $factoryCalendar->getWorkHours(),
            $factoryCalendar->getCalendarDays(),
            $factoryCalendar->getWorkDays(),
            $factoryCalendar->getWeekendHolidaysDays(),
            $factoryCalendar->getCreatedAt(),
            $factoryCalendar->getUpdatedAt(),
        ]);
    }

    public function delete(FactoryCalendar $factoryCalendar): bool
    {
        $key = get_class($factoryCalendar) . $factoryCalendar->getId();
        $this->identityMap->deleteByKey($key);

        return $this->deleteStmt->execute([$factoryCalendar->getId()]);
    }
}