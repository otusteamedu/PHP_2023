<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository;

use IilyukDmitryi\App\Domain\Entity\Transaction;
use IilyukDmitryi\App\Domain\Repository\TransactionRepositoryInterface;
use IilyukDmitryi\App\Domain\ValueObject\Currency;
use PDO;
use PDOStatement;

class TransactionRepository implements TransactionRepositoryInterface
{
    public const TABLE_NAME = 'transaction';
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteByIdStmt;
    private PDOStatement $findByEventIdStmt;
    
    private ?IdentityMap $identityMap = null;
    
    public function __construct(
        PDO $pdo,
    ) {
        $this->identityMap = new IdentityMap();
        $this->pdo = $pdo;
        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO '.static::TABLE_NAME.' (id, event_id, from_user_id, to_user_id, cost) VALUES (:id, :event_id, :from_user_id, :to_user_id, :cost)'
            );
        
        $this->updateStmt = $this->pdo
            ->prepare(
                ' UPDATE '.static::TABLE_NAME.' SET event_id = :event_id, from_user_id = :from_user_id, to_user_id = :to_user_id, cost = :cost WHERE id=:id'
            );
        
        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE id = :id');
        
        $this->findByEventIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE event_id = :event_id');
        
        $this->deleteByIdStmt = $this->pdo
            ->prepare('DELETE FROM '.static::TABLE_NAME.' WHERE id = :id');
    }
    
    /**
     * @param Transaction $transaction
     * @return array
     */
    public static function transactionToRaw(Transaction $transaction): array
    {
        return [
            'id' => $transaction->getId(),
            'event_id' => $transaction->getEventId(),
            'from_user_id' => $transaction->getFromUserId(),
            'to_user_id' => $transaction->getToUserId(),
            'cost' => $transaction->getCost()->getRaw(),
        ];
    }
    
    /**
     * @param $arrFields
     * @return Transaction
     */
    public static function rawToTransaction($arrFields): Transaction
    {
        return (new Transaction())
            ->setId($arrFields['id'] ?? 0)
            ->setEventId($arrFields['event_id'] ?? 0)
            ->setFromUserId($arrFields['from_user_id'] ?? 0)
            ->setToUserId($arrFields['to_user_id'] ?? 0)
            ->setCost(new Currency($arrFields['cost'] ?? 0));
    }
    
    public function getById(int $id): ?Transaction
    {
        if($object = $this->identityMap->get($id)){
            return $object;
        }
        
        $this->getByIdStmt->execute(['id' => $id]);
        $raw = $this->getByIdStmt->fetch();
        
        if ($raw) {
            $transaction = static::rawToTransaction($raw);
            $this->identityMap->set($id, $transaction);
            return $transaction;
        }
        return null;
    }
    
    public function add(Transaction $transaction): int
    {
        $fields = self::transactionToRaw($transaction);
        if ($fields['id'] === 0) {
            $fields['id'] = null;
        }
        
        $this->insertStmt->execute(self::transactionToRaw($transaction));
        $id = (int)$this->pdo->lastInsertId();
        $transaction = $this->getById($id);
        
        if (null === $transaction) {
            throw new \Exception('transaction no exist');
        }
        return $id;
    }
    
    public function update(Transaction $transaction): void
    {
        $this->identityMap->remove($transaction->getId());
        $this->updateStmt->execute(self::transactionToRaw($transaction));
        //$id = (int)$this->pdo->lastInsertId();
        $transaction = $this->getById($transaction->getId());
        
        if (null === $transaction) {
            throw new \Exception('transaction no exist');
        }
    }
    
    public function delete(int $id): void
    {
        if ($this->deleteByIdStmt->execute(['id' => $id]) === false) {
            throw new \Exception('error delete transaction '.$id);
        }
    }
    
    public function findByEventId(int $eventId): array
    {
        $arr = [];
        $this->findByEventIdStmt->execute(['event_id' => $eventId]);
        $raw = $this->findByEventIdStmt->fetchAll();
        
        if ($raw) {
            foreach ($raw as $item) {
                $arr[] = static::rawToTransaction($item);
            }
        }
        
        return $arr;
    }
}