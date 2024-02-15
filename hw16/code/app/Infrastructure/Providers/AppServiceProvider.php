<?php

namespace App\Infrastructure\Providers;

use App\Domains\Order\Application\CreateOrderUseCase;
use App\Domains\Order\Application\Factories\Order\OrderPhoneFactory;
use App\Domains\Order\Application\Factories\Order\OrderShopFactory;
use App\Domains\Order\Application\Factories\Order\OrderSiteFactory;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder\CreateOrderFromPhoneMutation;
use App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder\CreateOrderFromShopMutation;
use App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder\CreateOrderFromSiteMutation;
use App\Domains\Order\Infrastructure\Repository\OrderDatabaseRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerFactory();
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
        $this->app->singleton(OrderRepositoryInterface::class, OrderDatabaseRepository::class);
    }

    private function registerFactory(): void
    {
    }
}
