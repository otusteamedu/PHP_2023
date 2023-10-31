<?php


namespace IilyukDmitryi\App\Domain\Model;

use DI\DependencyException;
use DI\NotFoundException;
use IilyukDmitryi\App\Di;
use IilyukDmitryi\App\Domain\Entity\Event;
use IilyukDmitryi\App\Domain\Entity\Purchase;
use IilyukDmitryi\App\Domain\Entity\Transaction;
use IilyukDmitryi\App\Domain\Entity\User;
use IilyukDmitryi\App\Domain\Entity\UserPurchase;
use IilyukDmitryi\App\Domain\Exception\UserException;
use IilyukDmitryi\App\Domain\Repository\FactoryRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\PurchaseRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\UserPurchaseRepositoryInterface;
use IilyukDmitryi\App\Domain\Repository\UserRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Currency;

class PurchaseModel
{
    
    private static ?PurchaseRepositoryInterface $purchaseRepository = null;
    private static ?UserPurchaseRepositoryInterface $userPurchaseRepository = null;
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct()
    {
        self::makePurchaseRepository();
        self::makeUserPurchaseRepository();
    }
    
    /**
     * @throws DependencyException
     * @throws UserException
     */
    public function joinPurchase(int $purchaseId, int $userId): int
    {
        $userPurchase = (new UserPurchase())->setPurchaseId($purchaseId)->setUserId($userId);
        
        if (static::$userPurchaseRepository->findPurchaseIdAndFromUserId($purchaseId, $userId)) {
            throw new UserException("Вы уже присоединились к покупке");
        }
        
        $purchase = static::$purchaseRepository->getById($purchaseId);
        if ($purchase->getUserId() === $userId) {
            throw new UserException("Вы не можете присоединиться, это покупка ваша");
        }
        
        return static::$userPurchaseRepository->add($userPurchase);
    }
    
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function addPurchase(
        Purchase $purchase,
    ): Purchase {
        self::makePurchaseRepository();
        return self::$purchaseRepository->add($purchase);
    }
    
    /**
     * @param int $eventId
     * @return Purchase[]
     */
    public function getPurchasesByEventIdOnlyJoinedUsers(int $eventId): array
    {
        $onlyJoined = [];
        $arPurchase = $this->getPurchasesByEventId($eventId);
        /** @var  $purchase Purchase */
        foreach($arPurchase  as $purchase) {
            if(!empty($purchase->getJoinUsers())){
                $onlyJoined[] = $purchase;
            }
       }
        return $onlyJoined;
    }
    public function getPurchasesByEventId(int $eventId): array
    {
        $purchasesResult = [];
        $arPurchase = self::$purchaseRepository->findByEventId($eventId);
        if(empty($arPurchase)){
            return $purchasesResult;
        }
        $userModel = new UserModel();
        
        /** @var $purchase Purchase */
        foreach ($arPurchase as $purchase){
            $purchaseId = $purchase->getId();
            $userPurchase = static::$userPurchaseRepository->findByPurchaseId( $purchase->getId());
            $arrUserPurchase = [];
            /** @var  $userPurchase UserPurchase */
            foreach ($userPurchase as $user){
                $arrUserPurchase[] = $userModel->getUserById($user->getUserId());
            }
            $purchase->setJoinUsers($arrUserPurchase);
        }
        return $arPurchase;
    }
    
    public static function purchaseToTransactions(Purchase $purchase): array
    {
        $arrTransaction = [];
        if($joinUsers = $purchase->getJoinUsers()){
            $cost = $purchase->getCost();
            $countUsers = count($joinUsers) + 1; // +1 for user created by purchase
            $rawCostToUser = (int)$cost->getRaw()/$countUsers;
            $costToUser = new Currency($rawCostToUser);
            /** @var User $user */
            foreach ($joinUsers as $user) {
                $fromUserId = $purchase->getUserId();
                $toUserId = $user->getId();
                
                $transaction = (new Transaction())
                    ->setFromUserId($fromUserId)
                    ->setToUserId($toUserId)
                    ->setCost($costToUser)
                    ->setEventId($purchase->getEventId());
                
                $arrTransaction[] = $transaction;
            }
        }
       return $arrTransaction;
    }
    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private static function makePurchaseRepository(): void
    {
        if(is_null(self::$purchaseRepository)){
            $c = Di::getContainer();
            $factoryRepository = $c->get(FactoryRepositoryInterface::class);
            /** @var $PurchaseRepository  PurchaseRepositoryInterface */
            self::$purchaseRepository = $factoryRepository->getPurchaseRepository();
        }
    }    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private static function makeUserPurchaseRepository(): void
    {
        if(is_null(self::$userPurchaseRepository)){
            $c = Di::getContainer();
            $factoryRepository = $c->get(FactoryRepositoryInterface::class);
            /** @var $UserPurchaseRepository  UserPurchaseRepositoryInterface */
            self::$userPurchaseRepository = $factoryRepository->getUserPurchaseRepository();
        }
    }
    
}