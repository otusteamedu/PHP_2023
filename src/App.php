<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\EventProvider\RedisEventProvider;
use Otus\App\EventSystem\EventSystem;
use Predis\Client;

final class App
{
    public function run(): void
    {
        $redisEventProvider = new RedisEventProvider(new Client());

        (new EventSystem($redisEventProvider))->process();
    }
}
