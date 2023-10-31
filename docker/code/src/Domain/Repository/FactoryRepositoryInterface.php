<?php


namespace IilyukDmitryi\App\Domain\Repository;

interface FactoryRepositoryInterface
{
    public function getEventRepository(): EventRepositoryInterface;
    public function getPurchaseRepository(): PurchaseRepositoryInterface;
    public function getUserRepository(): UserRepositoryInterface;
    public function getUserPurchaseRepository(): UserPurchaseRepositoryInterface;
    public function getTransactionRepository(): TransactionRepositoryInterface;
}