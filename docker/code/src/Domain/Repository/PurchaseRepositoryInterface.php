<?php

namespace IilyukDmitryi\App\Domain\Repository;

use IilyukDmitryi\App\Domain\Entity\Purchase;

interface PurchaseRepositoryInterface
{
    public function getById(int $id):?Purchase;
    public function add(Purchase $purchase): Purchase;
    public function update(Purchase $purchase): Purchase;
    public function delete(int $id): void;
}