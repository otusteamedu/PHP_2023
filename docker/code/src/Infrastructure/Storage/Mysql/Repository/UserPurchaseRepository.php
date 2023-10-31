<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository;

use IilyukDmitryi\App\Domain\Entity\UserPurchase;
use IilyukDmitryi\App\Domain\Repository\UserPurchaseRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Currency;
use PDO;
use PDOStatement;

class UserPurchaseRepository implements UserPurchaseRepositoryInterface
{
    public const TABLE_NAME = 'user_purchase';
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteByIdStmt;
    private PDOStatement $findPurchaseIdStmt;
    private PDOStatement $findByUserIdAndPurchaseIdStmt;
    
    private ?IdentityMap $identityMap = null;
    
    public function __construct(
        PDO $pdo,
    ) {
        $this->identityMap = new IdentityMap();
        $this->pdo = $pdo;
        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO '.static::TABLE_NAME.' (id, purchase_id, user_id) VALUES (:id, :purchase_id, :user_id)'
            );
        
        $this->updateStmt = $this->pdo
            ->prepare(
                'UPDATE '.static::TABLE_NAME.' SET purchase_id = :purchase_id, user_id = :user_id'
            );
        
        $this->findPurchaseIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE purchase_id = :purchase_id');
        
        $this->findByUserIdAndPurchaseIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE purchase_id = :purchase_id AND user_id = :user_id');
        
        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE id = :id');
        
        $this->deleteByIdStmt = $this->pdo
            ->prepare('DELETE FROM '.static::TABLE_NAME.' WHERE id = :id');
    }
    
    /**
     * @param UserPurchase $purchase
     * @return array
     */
    public static function purchaseToRaw(UserPurchase $purchase): array
    {
        return [
            'id' => $purchase->getId(),
            'purchase_id' => $purchase->getPurchaseId(),
            'user_id' => $purchase->getUserId(),
        ];
    }
    
    /**
     * @param $arrFields
     * @return UserPurchase
     */
    public static function rawToPurchase($arrFields): UserPurchase
    {
        return (new UserPurchase())
            ->setId((int)$arrFields['id'] ?? 0)
            ->setPurchaseId((int)$arrFields['purchase_id'] ?? 0)
            ->setUserId((int)$arrFields['user_id'] ?? 0);
    }
    
    public function findByPurchaseId(int $purchaseId): array
    {
        $arr = [];
        $this->findPurchaseIdStmt->execute(['purchase_id' => $purchaseId]);
        $raw = $this->findPurchaseIdStmt->fetchAll();
        
        if ($raw) {
            foreach ($raw as $item) {
                $arr[] = static::rawToPurchase($item);
            }
        }
        
        return $arr;
    }
    
    public function getById(int $id): ?UserPurchase
    {
        if($object = $this->identityMap->get($id)){
            return $object;
        }
        
        $this->getByIdStmt->execute(['id' => $id]);
        $raw = $this->getByIdStmt->fetch();
        
        if ($raw) {
            $purchase = static::rawToPurchase($raw);
            $this->identityMap->set($id, $purchase);
            return $purchase;
        }
        
        return null;
    }
    
    public function add(UserPurchase $userPurchase): int
    {
        $fields = self::purchaseToRaw($userPurchase);
        if ($fields['id'] === 0) {
            $fields['id'] = null;
        }
        
        $this->insertStmt->execute($fields);
        $id = (int)$this->pdo->lastInsertId();
        $userPurchase = $this->getById($id);
        
        if (null === $userPurchase) {
            throw new \Exception('userPurchase no exist');
        }
        return $id;
    }
    
    public function update(UserPurchase $userPurchase): void
    {
        $this->identityMap->remove($userPurchase->getId());
        $this->updateStmt->execute(self::purchaseToRaw($userPurchase));
        $userPurchase = $this->getById($userPurchase->getId());
        
        if (null === $userPurchase) {
            throw new \Exception('userPurchase no exist');
        }
    }
    
    /**
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        $res = $this->deleteByIdStmt->execute(['id' => $id]);
        if ($res === false) {
            throw new \Exception('error delete userPurchase '.$id);
        }
        $this->identityMap->remove($id);
    }
    
    public function findPurchaseIdAndFromUserId( int $purchaseId,int $userId): array
    {
        $arPurchase = [];
        $this->findByUserIdAndPurchaseIdStmt->execute(['user_id' => $userId, 'purchase_id' => $purchaseId]);
        $itemsRaw = $this->findByUserIdAndPurchaseIdStmt->fetchAll();
        
        if ($itemsRaw) {
            foreach ($itemsRaw as $raw) {
                $purchase = static::rawToPurchase($raw);
                $arPurchase[] = $purchase;
            }
        }
        return $arPurchase;
    }
    
}