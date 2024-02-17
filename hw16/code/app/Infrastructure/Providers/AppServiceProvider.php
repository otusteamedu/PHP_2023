<?php

namespace App\Infrastructure\Providers;

use App\Domains\Order\Application\Factories\Product\AbstractProductFactory;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Domain\Repository\ProductRepositoryInterface;
use App\Domains\Order\Infrastructure\Repository\OrderDatabaseRepository;
use App\Domains\Order\Infrastructure\Repository\ProductDatabaseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerFactory();
    }

    public function boot(): void
    {
    }

    private function registerRepositories()
    {
        $this->app->singleton(OrderRepositoryInterface::class, OrderDatabaseRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, ProductDatabaseRepository::class);
    }

    private function registerFactory(): void
    {
        $this->app->singleton(AbstractProductFactory::class, AbstractProductFactory::class);
    }
}
