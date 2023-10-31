<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository;

use IilyukDmitryi\App\Domain\Entity\Purchase;
use IilyukDmitryi\App\Domain\Model\PurchaseModel;
use IilyukDmitryi\App\Domain\Repository\PurchaseRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Currency;
use PDO;
use PDOStatement;

use function DI\value;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public const TABLE_NAME = 'purchase';
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $listAllStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $findByEventIdStmt;
    private PDOStatement $deleteByIdStmt;
    
    private ?IdentityMap $identityMap = null;
    
    
    public function __construct(
        PDO $pdo,
    ) {
        $this->identityMap = new IdentityMap();
        $this->pdo = $pdo;
        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO '.static::TABLE_NAME.' ( event_id, user_id,name,cost) VALUES ( :event_id, :user_id, :name, :cost)'
            );
        
        $this->updateStmt = $this->pdo
            ->prepare(
                'UPDATE '.static::TABLE_NAME.' SET event_id = :event_id, user_id = :user_id,name = :name, cost = :cost WHERE id=:id'
            );
        
        $this->listAllStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' ORDER BY id DESC');
        
        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE id = :id');
        
        $this->findByEventIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE event_id = :event_id ORDER BY id ASC');
        
        $this->deleteByIdStmt = $this->pdo
            ->prepare('DELETE FROM '.static::TABLE_NAME.' WHERE id = :id');
        
    }
    
    /**
     * @param Purchase $purchase
     * @return array
     */
    public static function purchaseToRaw(Purchase $purchase): array
    {
        return [
            'id' => $purchase->getId(),
            'event_id' => $purchase->getEventId(),
            'name' => $purchase->getName(),
            'user_id' => $purchase->getUserId(),
            'cost' => $purchase->getCost()->getRaw(),
        ];
    }
    
    /**
     * @param $arrFields
     * @return Purchase
     */
    public static function rawToPurchase($arrFields): Purchase
    {
        return (new Purchase())
            ->setId((int)$arrFields['id'] ?? 0)
            ->setEventId((int)$arrFields['event_id'] ?? 0)
            ->setName($arrFields['name'] ?? "")
            ->setUserId((int)$arrFields['user_id'] ?? 0 )
            ->setCost(new Currency($arrFields['cost']));
    }
    
 /*
  *     public function select(string $query, array $params = []): array {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
 
  * */
    
    public function findByEventId(int $eventId): array
    {
        $arr = [];
        $this->findByEventIdStmt->execute(['event_id' => $eventId]);
        $raw = $this->findByEventIdStmt->fetchAll();
        
        if ($raw) {
            foreach ($raw as $item) {
                $arr[] = static::rawToPurchase($item);
            }
        }
        
        return $arr;
    }
    
    public function getById(int $id): ?Purchase
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
    
    public function add(Purchase $purchase): Purchase
    {
        $fields = self::purchaseToRaw($purchase);
        unset($fields['id']);
        $this->insertStmt->execute($fields);
        $id = (int)$this->pdo->lastInsertId();
        $purchase = $this->getById($id);
        
        if (null === $purchase) {
            throw new \Exception('purchase no exist');
        }
        return $purchase;
    }
    
    public function update(Purchase $purchase): Purchase
    {
        $this->identityMap->remove($purchase->getId());
        $this->updateStmt->execute(self::purchaseToRaw($purchase));
        $purchase = $this->getById($purchase->getId());
        
        if (null === $purchase) {
            throw new \Exception('purchase no exist');
        }
        return $purchase;
    }
    
    public function delete(int $id): void
    {
        $res = $this->deleteByIdStmt->execute(['id'=>$id]);
        if($res===false) {
            throw new \Exception('error delete purchase '.$id);
        }
    }
    
}