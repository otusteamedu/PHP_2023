<?php

namespace App\Models;

class CookingStatus implements Observer
{
    private $status;

    public function update(string $status)
    {
        $this->status = $status;
        echo "Статус приготовления: $status\n";
    }
}
