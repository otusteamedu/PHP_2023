<?php

namespace App\Infrastructure\DataMapper;

use App\Domain\Entity\ApplicationForm;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;
use App\Infrastructure\Db\Db;
use Exception;
use PDO;
use PDOStatement;
use ReflectionException;

class ApplicationFormMapper
{
    use SetEntityIdTrait;

    private PDO $pdo;

    private PDOStatement $selectStmt;

    private PDOStatement $selectAllStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $deleteStmt;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->pdo = Db::getPdo();

        $this->selectStmt = $this->pdo->prepare(
            "select email, message, status_id from application_form where id = ?"
        );

        $this->selectAllStmt = $this->pdo->prepare(
            "select * from application_form"
        );

        $this->insertStmt = $this->pdo->prepare(
            "insert into application_form (email, message, status_id) values (?, ?, ?)"
        );

        $this->updateStmt = $this->pdo->prepare(
            "update application_form set email = ?, message = ?, status_id = ?  where id = ?"
        );

        $this->deleteStmt = $this->pdo->prepare("delete from application_form where id = ?");
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function findById(int $id): ?ApplicationForm
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if ($result === false) {
            return null;
        }

        $status = (new StatusMapper())->findById($result['status_id']);
        $applicationForm = new ApplicationForm(
            new Email($result['email']),
            new Message($result['message']),
            $status
        );
        self::setId($applicationForm, $id);

        return $applicationForm;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function findAll(): array
    {
        $this->selectAllStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStmt->execute();
        $result = $this->selectAllStmt->fetchAll();
        $applicationFormAll = [];

        if ($result === false) {
            return $applicationFormAll;
        }

        foreach ($result as $item) {
            $status = (new StatusMapper())->findById($item['status_id']);
            $applicationForm = new ApplicationForm(
                new Email($item['email']),
                new Message($item['message']),
                $status
            );
            self::setId($applicationForm, $item['id']);
            $applicationFormAll[] = $applicationForm;
        }

        return $applicationFormAll;
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function insert(ApplicationForm $applicationForm): ApplicationForm
    {
        $this->insertStmt->execute(
            [$applicationForm->getEmail()->getValue(), $applicationForm->getMessage()->getValue(), $applicationForm->getStatus()->getId()]
        );

        $id = $this->pdo->lastInsertId();
        self::setId($applicationForm, $id);

        return $applicationForm;
    }

    public function update(ApplicationForm $applicationForm): bool
    {
        return $this->updateStmt->execute([
            $applicationForm->getEmail()->getValue(),
            $applicationForm->getMessage()->getValue(),
            $applicationForm->getStatus()->getId(),
            $applicationForm->getId()
        ]);
    }

    public function delete(ApplicationForm $applicationForm): bool
    {
        return $this->deleteStmt->execute([$applicationForm->getId()]);
    }
}
