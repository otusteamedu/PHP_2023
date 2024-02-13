<?php

namespace App\Infrastructure\Providers;

use App\Domains\Order\Application\CreateOrderUseCase;
use App\Domains\Order\Application\Factories\Order\OrderPhoneFactory;
use App\Domains\Order\Domain\Repository\OrderRepositoryInterface;
use App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder\CreateOrderPhoneMutation;
use App\Domains\Order\Infrastructure\GraphQL\Mutations\CreateOrder\CreateOrderSiteMutation;
use App\Domains\Order\Infrastructure\Repository\DatabaseOrderRepository;
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
        $this->app->bind(CreateOrderPhoneMutation::class, function () {
            return new CreateOrderPhoneMutation(
                new CreateOrderUseCase(new OrderPhoneFactory()),
            );
        });

        $this->app->bind(CreateOrderSiteMutation::class, function () {
            return new CreateOrderSiteMutation(
                new CreateOrderUseCase(new OrderSiteFactory()),
            );
        });
    }
}
