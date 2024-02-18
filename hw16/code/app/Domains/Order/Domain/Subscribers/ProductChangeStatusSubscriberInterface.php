<?php

namespace App\Domains\Order\Domain\Subscribers;

interface ProductChangeStatusSubscriberInterface
{
    public function run(): void;
}
