<?php

declare(strict_types=1);

namespace App\Application\Observer;

interface SubscriberInterface
{
    public function update(EventInterface $event): void;
}
