<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Entity\Transaction;

interface TransactionRepositoryInterface
{
    public function getById(int $id):?Transaction;
    public function add(Transaction $user): int;
    public function update(Transaction $user): void;
    public function delete(int $id): void;
    public function findByEventId(int $eventId): array;
}