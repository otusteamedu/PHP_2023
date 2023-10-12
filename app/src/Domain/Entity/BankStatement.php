<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Constant\BankStatementStatus;
use App\Domain\ValueObject\Id;

/**
 * @final
 */
class BankStatement
{
    public function __construct(
        private Id $id,
        private User $user,
        private BankStatementStatus $status,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getStatus(): BankStatementStatus
    {
        return $this->status;
    }

    public function setStatus(BankStatementStatus $status): void
    {
        $this->status = $status;
    }
}
