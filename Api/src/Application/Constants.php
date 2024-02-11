<?php

namespace App\Application;

class Constants
{
    public const QUEUE_NAME = 'events.transactions-service';
    public const EXCHANGE_NAME = 'events';
    public const ROUTING_KEY = 'payment_succeeded';
    public const REQUEST_STATUS_CREATED = 'created';
    public const REQUEST_STATUS_PROCESSING = 'processing';
    public const REQUEST_STATUS_PROCESSED = 'processed';
}
