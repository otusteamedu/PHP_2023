<?php

namespace App\Infrastructure;

class Constants
{
    public const QUEUE_NAME = 'events.transactions-service';
    public const EXCHANGE_NAME = 'events';
    public const DATE_FROM = 'dateFrom';
    public const DATE_TO = 'dateTo';
    public const ROUTING_KEY = 'payment_succeeded';
    public const CHAT_ID = 'chatId';
}
