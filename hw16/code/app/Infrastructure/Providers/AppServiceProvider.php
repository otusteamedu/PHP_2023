<?php

namespace App\Infrastructure\Providers;

use App\Domains\Order\Domain\Factories\Product\AbstractProductFactory;
use App\Domains\Order\Domain\Factories\Product\ProductFactory;
use App\Domains\Order\Domain\Publishers\PublisherProductChangeStatus;
use App\Domains\Order\Domain\Publishers\PublisherProductChangeStatusInterface;
use App\Domains\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Domains\Order\Domain\Repositories\ProductRepositoryInterface;
use App\Domains\Order\Domain\Strategies\Cock\CockStrategyInterface;
use App\Domains\Order\Domain\Strategies\Cock\GrillCockStrategy;
use App\Domains\Order\Domain\Subscribers\SendNotificationsService;
use App\Domains\Order\Infrastructure\Repository\OrderDatabaseRepository;
use App\Domains\Order\Infrastructure\Repository\ProductDatabaseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerFactory();
        $this->registerStrategies();
        $this->registerPublishers();
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
        $this->app->singleton(AbstractProductFactory::class, ProductFactory::class);
    }

    private function registerStrategies(): void
    {
        $this->app->singleton(CockStrategyInterface::class, GrillCockStrategy::class);
    }

    private function registerPublishers(): void
    {
        $this->app->bind(PublisherProductChangeStatusInterface::class, function ($app) {
           $publisher = new PublisherProductChangeStatus();
           $publisher->subscribe(new SendNotificationsService());
        });
    }
}
