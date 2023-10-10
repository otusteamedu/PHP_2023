<?php

namespace App\Models;

class Employee
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $surname,
        public string $phone
    ) {
        //
    }

    public function asArray(): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'surname' => $this->surname,
            'phone'   => $this->phone
        ];
    }

    public function setID(int $id): self
    {
        $this->id = $id;

        return $this;
    }

}
