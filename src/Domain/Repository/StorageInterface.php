<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Event;
use App\Domain\ValueObject\Condition;

interface StorageInterface
{
    public function add(Event $event): void;

    public function clearAll(): void;

    /**
     * @param Condition[] $conditions
     */
    public function findOneByConditions(array $conditions): Event;
}
