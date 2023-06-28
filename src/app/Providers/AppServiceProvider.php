<?php

namespace App\Providers;

use App\Http\Controllers\SubscriberController;
use App\Services\SubscriberEventsProxy;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SubscriberEventsProxy::class, function ($app) {
            $request = $app->make(Request::class);
            $subscriber = $request->route('subscriber');
            return new SubscriberEventsProxy($subscriber);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
