<?php

namespace App\Domains\Order_1\Domain\Models;

use App\Domains\Order\Domain\ValueObjects\Description;
use App\Domains\Order\Domain\ValueObjects\Email;
use App\Domains\Order\Domain\ValueObjects\Title;

class Order
{
    private int $id;

    public function __construct(
        private Title $title,
        private Description $description,
        private Email $email,
    ) {
    }

    public function setTitle(Title $title): Order
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(Description $description): Order
    {
        $this->description = $description;
        return $this;
    }

    public function setEmail(Email $email): Order
    {
        $this->email = $email;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->getEmail()->getValue(),
            'title' => $this->getTitle()->getValue(),
            'description' => $this->getDescription()->getValue(),
        ];
    }
}
