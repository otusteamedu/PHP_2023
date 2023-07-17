<?php

declare(strict_types=1);

namespace Otus\App\EventProvider;

use Predis\Client;

interface EventProviderFactoryInterface
{
    public function create(): EventProviderInterface;
}
