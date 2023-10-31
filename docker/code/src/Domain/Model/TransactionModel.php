<?php


namespace IilyukDmitryi\App\Domain\Model;

use DI\DependencyException;
use DI\NotFoundException;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Entity\Transaction;
use IilyukDmitryi\App\Domain\Repository\FactoryRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\TransactionRepositoryInterface;

class TransactionModel
{
    
    private static ?TransactionRepositoryInterface $transactionRepository = null;
  
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        self::makeTransactionRepository();
    }
    
    /**
     * @param int $eventId
     * @return Transaction[]
     */
    public function  getTransactionByEventId(int $eventId):array
    {
        $transactions = static::$transactionRepository->findByEventId($eventId);
        return $transactions;
    }
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private static function makeTransactionRepository(): void
    {
        if(is_null(self::$transactionRepository)){
            $c = Di::getContainer();
            $factoryRepository = $c->get(FactoryRepositoryInterface::class);
            /** @var $TransactionRepository  TransactionRepositoryInterface */
            self::$transactionRepository = $factoryRepository->getTransactionRepository();
        }
    }

    
    
}