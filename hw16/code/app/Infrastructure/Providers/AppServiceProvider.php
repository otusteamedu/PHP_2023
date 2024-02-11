<?php

namespace App\Infrastructure\Providers;

use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Infrastructure\Repository\DatabaseOrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepositories()
    {
        $this->app->singleton(OrderRepositoryInterface::class, DatabaseOrderRepository::class);
    }
}
