<?php

declare(strict_types=1);

namespace App\Modules\Orders\Domain\Entity;

use App\Modules\Orders\Domain\ValueObject\Comment;
use App\Modules\Orders\Domain\ValueObject\Email;
use App\Modules\Orders\Domain\ValueObject\UUID;

class Order
{
    public function __construct(
        private UUID $uid,
        private Email $email,
        private Comment $comment,
    )
    {}

    public function getUuid(): UUID
    {
        return $this->uid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }

}
