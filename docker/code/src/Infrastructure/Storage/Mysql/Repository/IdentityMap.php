<?php

namespace IilyukDmitryi\App\Infrastructure\Storage\Mysql\Repository;
class IdentityMap
{
    private array $objects = [];
    
    /**
     * @param int $id
     * @return object|null
     */
    public function get(int $id): ?object
    {
        return $this->objects[$id] ?? null;
    }
    
    /**
     * @param int    $id
     * @param object $object
     * @return void
     */
    public function set(int $id, $object): void
    {
        $this->objects[$id] = $object;
    }
    
    /**
     * @param int $id
     * @param     $object
     * @return void
     */
    public function remove(int $id): void
    {
        if (isset($this->objects[$id])) {
            unset($this->objects[$id]);
        }
    }
    
    /**
     * @return void
     */
    public function removeAll(): void
    {
        unset($this->objects);
    }
    
    /*
     *         if (count($transactionOptimised)) {
            $userModel = new UserModel();
            $arrUser = [];
            /** @var Transaction $transaction  */
  /*          foreach ($transactionOptimised as $transaction) {
            $fromUserId = $transaction->getFromUserId();
            if (!isset($arrUser[$fromUserId])) {
            $arrUser[$fromUserId] = $userModel->getUserById($fromUserId);
            }
            if (isset($arrUser[$fromUserId])) {
                $transaction->setFromUser($arrUser[$fromUserId]);
            }
            
            $toUserId = $transaction->getToUserId();
            if (!isset($arrUser[$toUserId])) {
                $arrUser[$toUserId] = $userModel->getUserById($toUserId);
            }
            if (isset($arrUser[$toUserId])) {
                
                $transaction->setToUser($arrUser[$toUserId]);
            }
            }
            }
     * */
}
