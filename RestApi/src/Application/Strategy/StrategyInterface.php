<?php

namespace App\Application\Strategy;

use App\Domain\Entity\Contract\PublishAbleInterface;

interface StrategyInterface
{
    public function notify(PublishAbleInterface $category): void;
}
