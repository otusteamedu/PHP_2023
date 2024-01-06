<?php

namespace App\Application\Helper;

class NotifyHelper
{
    public function getSupports(): array
    {
        return ['email', 'telegram',];
    }
}
