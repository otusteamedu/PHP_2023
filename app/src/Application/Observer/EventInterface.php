<?php

declare(strict_types=1);

namespace App\Application\Observer;

interface EventInterface
{
    public function getObject(): object;
}
