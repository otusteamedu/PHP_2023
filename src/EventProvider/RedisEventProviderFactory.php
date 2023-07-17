<?php

declare(strict_types=1);

namespace Otus\App\EventProvider;

use Predis\Client;

final class RedisEventProviderFactory implements EventProviderFactoryInterface
{
    public function create(): EventProviderInterface
    {
        return new RedisEventProvider(new Client());
    }
}