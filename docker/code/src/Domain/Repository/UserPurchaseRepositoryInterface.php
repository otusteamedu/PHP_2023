<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Entity\UserPurchase;

interface UserPurchaseRepositoryInterface
{
    public function getById(int $id):?UserPurchase;
    public function add(UserPurchase $userPurchase): int;
    public function update(UserPurchase $userPurchase): void;
    public function delete(int $id): void;
    public function findPurchaseIdAndFromUserId(int $purchaseId,int $userId): array;
    public function findByPurchaseId(int $purchaseId): array;
}