<?php

namespace App\DataMapper;

use App\Models\Employee;
use App\Models\EmployeeCollection;
use PDO;

class EmployeeDataMapper extends DataMapper
{
    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return 'employees';
    }
    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->selectStatement = $connection->prepare(
            'select * from self::getTableName() where id = ?'
        );
        $this->insertStatement = $connection->prepare(
            'insert into {self::getTableName()} (:id, :name, :surname, :phone) values (?, ?, ?, ?)'
        );
        $this->updateStatement = $connection->prepare(
            'update self::getTableName() set name = ?, surname = ?, phone = ? where id = ?',
        );
        $this->deleteStatement = $connection->prepare(
            'delete from self::getTableName() where id = ?'
        );
        $this->findAllStatement = $connection->prepare(
            'select * from self::getTableName()'
        );
    }
    /**
     * @return EmployeeCollection
     */
    public function findAll(): EmployeeCollection
    {
        $this->findAllStatement->execute();
        $collection = new EmployeeCollection();
        foreach ($this->findAllStatement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $collection->add(new Employee(
                $row['id'],
                $row['name'],
                $row['surname'],
                $row['phone']
            ));
        }
        return $collection;
    }
    /**
     * @param Employee $employee
     * @return bool
     */
    public function update(Employee $employee): bool
    {
        return $this->updateStatement->execute($employee->asArray());
    }
    /**
     * @param Employee $employee
     * @return Employee|null
     */
    public function insert(Employee $employee): ?Employee
    {
        if (!$this->insertStatement->execute($employee->asArray())) {
            return null;
        }
        return $employee->setId((int)$this->pdo->lastInsertId());
    }
    /**
     * @param Employee $employee
     * @return bool
     */
    public function delete(Employee $employee): bool
    {
        return $this->deleteStatement->execute([$employee->id]);
    }
}
