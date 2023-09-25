<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Repository;

use Art\Code\Domain\Entity\Request;
use Art\Code\Infrastructure\DTO\RequestDTO;
use Art\Code\Infrastructure\DTO\RequestReceivedDTO;
use PDO;
use PDOStatement;

class RequestRepository
{
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;
    private PDOStatement $selectStmt;


    public function __construct(
        private readonly PDO                     $pdo,
        private readonly UserRepository          $userRepository,
        private readonly RequestStatusRepository $requestStatusRepository,
        private readonly RequestTypeRepository   $requestTypeRepository
    )
    {
        $this->selectStmt = $pdo->prepare("select * from request where request_id = ?");
        $this->insertStmt = $pdo->prepare("insert into request (user_id, request_type_id, request_status_id, created_at, updated_at) values (?, ?, ?, now(), now())");
        $this->updateStmt = $pdo->prepare("update request set user_id = ?, request_type_id = ?, request_status_id = ? where request_id = ?");
        $this->deleteStmt = $pdo->prepare("delete from request where request_id = ?");
    }

    public function findById($id): ?Request
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        $user = $this->userRepository->findById($result['user_id']);
        $requestType = $this->requestTypeRepository->findById($result['request_type_id']);
        $requestStatus = $this->requestStatusRepository->findById($result['request_status_id']);

        $request = new Request();
        $request->setUser($user);
        $request->setType($requestType);
        $request->setStatus($requestStatus);

        return $request;
    }

    public function insertFromDTO(RequestDTO $requestDTO): int
    {
        $this->insertStmt->execute([$requestDTO->getUserId(), $requestDTO->getRequestTypeId(), $requestDTO->getRequestStatusId()]);

        return (int)$this->pdo->lastInsertId();
    }


    public function insert(Request $request): int
    {
        $this->insertStmt->execute([$request->getUser()->getId(), $request->getType()->getId(), $request->getStatus()->getId()]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(RequestReceivedDTO $receivedDTO): bool
    {
        return $this->updateStmt->execute([$receivedDTO->getUserId(), $receivedDTO->getRequestTypeId(), $receivedDTO->getRequestStatusId()]);
    }

    public function updateStatus(int $status_id, int $request_id): bool
    {
        $prepare = $this->pdo->prepare("update request set request_status_id = ? where request_id = ? ");
        return $prepare->execute([$status_id, $request_id]);
    }

    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}