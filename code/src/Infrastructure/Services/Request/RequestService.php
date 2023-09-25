<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\Services\Request;

use Art\Code\Domain\Entity\Request;
use Art\Code\Infrastructure\DTO\RequestDTO;
use Art\Code\Infrastructure\DTO\RequestReceivedDTO;
use Art\Code\Infrastructure\Repository\RequestRepository;
use Art\Code\Infrastructure\Repository\RequestStatusRepository;
use Art\Code\Infrastructure\Repository\RequestTypeRepository;
use Art\Code\Infrastructure\Repository\UserRepository;
use Art\Code\Infrastructure\Services\Queue\EmailPublisher\EmailPublisher;
use JsonException;
use PDO;

class RequestService
{
    /**
     * @throws JsonException
     */
    public function createRequest(RequestReceivedDTO $dto, EmailPublisher $emailPublisher): bool
    {
        /*
         * Сходить в базу собрать данные
         * */
        sleep(5);

        /*
         * Отправить письмо с итогом
         * */
        $emailPublisher->send(['from' => 'config.email', 'title' => 'letter_title', 'to' => $dto->getEmail(), 'body' => [1, 2, 3, 4]]);

        return true;
    }

    public function saveRequest(PDO $pdo, RequestDTO $requestDTO): int
    {
        $requestTypeRepository = new RequestTypeRepository($pdo);
        $requestStatusRepository = new RequestStatusRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository);

        return $requestRepository->insertFromDTO($requestDTO);
    }

    public function getRequest(PDO $pdo, int $request_id): ?Request
    {
        $requestTypeRepository = new RequestTypeRepository($pdo);
        $requestStatusRepository = new RequestStatusRepository($pdo);
        $userRepository = new UserRepository($pdo);
        $requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository);

        return $requestRepository->findById($request_id);
    }
}