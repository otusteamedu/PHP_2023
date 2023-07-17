<?php

declare(strict_types=1);

namespace Otus\App;

use Otus\App\EventProvider\EventProviderFactoryInterface;
use Otus\App\EventSystem\EventSystem;

final class App
{
    public function run(EventProviderFactoryInterface $eventProviderFactory): void
    {
        (new EventSystem($eventProviderFactory->create()))->process();
    }
}
