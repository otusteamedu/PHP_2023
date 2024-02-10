<?php

namespace App\Infrastructure;

class Constants
{
    public const QUEUE_NAME = 'events.transactions-service';
    public const EXCHANGE_NAME = 'events';
    public const ROUTING_KEY = 'payment_succeeded';
}
