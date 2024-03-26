<?php

declare(strict_types=1);

namespace App\Modules\Orders\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;

class OrderModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Modules\Orders\Domain\QueueMessageBrokers\OrderQueueMessageBrokerInterface',
            'App\Modules\Orders\Infrastructure\QueueMessageBrokers\OrderRabbitMQMessageBroker'
        );

        $this->app->bind(
            'App\Modules\Orders\Domain\Repository\OrderRepositoryInterface',
            'App\Modules\Orders\Infrastructure\Repository\OrderDBRepository'
        );
    }
}
