<?php

namespace IilyukDmitryi\App\Domain\Model;

use DI\DependencyException;
use DI\NotFoundException;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Entity\Event;
use IilyukDmitryi\App\Domain\Entity\Transaction;
use IilyukDmitryi\App\Domain\Repository\EventRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\FactoryRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Currency;

class EventModel
{
    private static ?EventRepositoryInterface $eventRepository = null;
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        self::makeRepository();
    }
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private static function makeRepository(): void
    {
        if (is_null(self::$eventRepository)) {
            $c = Di::getContainer();
            $factoryRepository = $c->get(FactoryRepositoryInterface::class);
            
            /** @var $EventRepository  EventRepositoryInterface */
            self::$eventRepository = $factoryRepository->getEventRepository();
        }
    }
    
    
    public function getActualDebtsTransactionByEventId(int $eventId): array
    {
        $arTransactions = array_merge(
            $this->getDebtsTransactionByEventId($eventId) + $this->getPaidDebtsTransactionByEventId($eventId)
        );
        $transactionOptimised = static::getOptimisedTransaction($arTransactions);
        return $transactionOptimised;
    }
    
    public function getDebtsTransactionByEventId(int $eventId): array
    {
        $purchaseModel = new PurchaseModel();
        $purchaseList = $purchaseModel->getPurchasesByEventIdOnlyJoinedUsers($eventId);
        $arTransactions = [];
        foreach ($purchaseList as $purchase) {
            $purchaseTransactions = PurchaseModel::purchaseToTransactions($purchase);
            if (count($purchaseTransactions) > 0) {
                $arTransactions = array_merge($arTransactions, $purchaseTransactions);
            }
        }
        
        return $arTransactions;
    }
    
    public function getPaidDebtsTransactionByEventId(int $eventId): array
    {
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->getTransactionByEventId($eventId);
        
        return $transactions;
    }
    
    
    public function getOrCreateEvent(Event $event): ?Event
    {
        $eventId = $event->getId();
        if ($eventId === 0 || self::$eventRepository->getById($eventId) === null) {
            $eventId = self::$eventRepository->add($event);
        }
        return self::$eventRepository->getById($eventId);
    }
    
    public function getOptimisedTransaction(array $transactions): array
    {
        $balances = [];
        /** @var $transaction Transaction */
        foreach ($transactions as $transaction) {
            $costRaw = $transaction->getCost()->getRaw();
            $fromUserId = $transaction->getFromUserId();
            $toUserId = $transaction->getToUserId();
            $balances[$fromUserId] = ($balances[$fromUserId] ?? 0) - $costRaw;
            $balances[$toUserId] = ($balances[$toUserId] ?? 0) + $costRaw;
        }
        
        $transactionsOptimised = [];
        
        while (!empty($balances)) {
            $minCreditor = min($balances);
            $maxDebtor = max($balances);
            
            if ($minCreditor === 0 && $maxDebtor === 0) {
                break;
            }
            
            $minCreditorId = array_search($minCreditor, $balances);
            $maxDebtorId = array_search($maxDebtor, $balances);
            
            $amount = min(abs($minCreditor), abs($maxDebtor));
            //$maxDebtorId, $minCreditorId, $amount
            $transactionsOptimised[] = (new Transaction())->setFromUserId($maxDebtorId)->setToUserId(
                $minCreditorId
            )->setCost(
                new Currency($amount)
            );
            
            $balances[$minCreditorId] += $amount;
            $balances[$maxDebtorId] -= $amount;
            
            if ($balances[$minCreditorId] === 0) {
                unset($balances[$minCreditorId]);
            }
            if ($balances[$maxDebtorId] === 0) {
                unset($balances[$maxDebtorId]);
           } 
        }
        return $transactionsOptimised;
    }
    
}
