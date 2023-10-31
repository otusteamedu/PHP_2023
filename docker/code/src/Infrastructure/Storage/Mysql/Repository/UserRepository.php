<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository;

use IilyukDmitryi\App\Domain\Entity\User;
use IilyukDmitryi\App\Domain\Repository\UserRepositoryInterface;
use PDO;
use PDOStatement;

class UserRepository implements UserRepositoryInterface
{
    public const TABLE_NAME = 'user';
    private PDO $pdo;
    private PDOStatement $insertStmt;
    private PDOStatement $getByIdStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteByIdStmt;
    
    private ?IdentityMap $identityMap = null;
    public function __construct(
        PDO $pdo,
    ) {
        $this->identityMap = new IdentityMap();
        
        $this->pdo = $pdo;
        $this->insertStmt = $this->pdo
            ->prepare(
                'INSERT INTO '.static::TABLE_NAME.' (id, name) VALUES (:id, :name)'
            );
        
        $this->updateStmt = $this->pdo
            ->prepare(
                ' UPDATE '.static::TABLE_NAME.' SET name = :name WHERE id=:id'
            );
        
        $this->listAllStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' ORDER BY id DESC');
        
        $this->getByIdStmt = $this->pdo
            ->prepare('SELECT * FROM '.static::TABLE_NAME.' WHERE id = :id');
        
        $this->deleteByIdStmt = $this->pdo
            ->prepare('DELETE FROM '.static::TABLE_NAME.' WHERE id = :id');
        
    }
    
    /**
     * @param User $user
     * @return array
     */
    public static function userToRaw(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
        ];
    }
    
    /**
     * @param $arrFields
     * @return User
     */
    public static function rawToUser($arrFields): User
    {
        return (new User())
            ->setId($arrFields['id'] ?? 0)
            ->setName($arrFields['name'] ?? "");
    }
    
    
    public function getById(int $id): ?User
    {
        if($object = $this->identityMap->get($id)){
            return $object;
        }
        
        $this->getByIdStmt->execute(['id' => $id]);
        $raw = $this->getByIdStmt->fetch();
        if ($raw) {
            $user = static::rawToUser($raw);
            $this->identityMap->set($id, $user);
            return $user;
        }
        return null;
    }
    
    public function add(User $user): int
    {
        $fields = self::userToRaw($user);
        if($fields['id'] === 0){
            $fields['id'] = null;
        }
        $this->insertStmt->execute(self::userToRaw($user));
        $id = (int)$this->pdo->lastInsertId();
        $user = $this->getById($id);
        
        if (null === $user) {
            throw new \Exception('user no exist');
        }
        return $id;
    }
    
    public function update(User $user): void
    {
        $this->identityMap->remove($user->getId());
        $this->updateStmt->execute(self::userToRaw($user));
        //$id = (int)$this->pdo->lastInsertId();
        $user = $this->getById($user->getId());
        
        if (null === $user) {
            throw new \Exception('user no exist');
        }
    }
    
    public function delete(int $id): void
    {
        if($this->deleteByIdStmt->execute(['id'=>$id])===false) {
            throw new \Exception('error delete user '.$id);
        }
        $this->identityMap->remove($id);
    }
}