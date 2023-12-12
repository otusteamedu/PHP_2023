<?php

namespace App\Infrastructure\DataMapper;

use App\Domain\Entity\ApplicationForm;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;
use Exception;
use PDO;
use PDOStatement;
use ReflectionException;

class ApplicationFormMapper
{
    use SetEntityIdTrait;

    private PDO $pdo;

    private PDOStatement $selectStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $deleteStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select email, message, status_id from application_form where id = ?"
        );

        $this->insertStmt = $pdo->prepare(
            "insert into application_form (email, message, status_id) values (?, ?, ?)"
        );

        $this->updateStmt = $pdo->prepare(
            "update application_form set email = ?, message = ?, status_id = ?  where id = ?"
        );

        $this->deleteStmt = $pdo->prepare("delete from application_form where id = ?");
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function findById(int $id): ApplicationForm
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $status = (new StatusMapper($this->pdo))->findById($result['status_id']);
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
    public function insert(array $raw): ApplicationForm
    {
        $this->insertStmt->execute([$raw['email'], $raw['message'], $raw['status_id']]);

        $id = $this->pdo->lastInsertId();
        $status = (new StatusMapper($this->pdo))->findById($raw['status_id']);
        $applicationForm = new ApplicationForm(
            new Email($raw['email']),
            new Message($raw['message']),
            $status
        );
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
