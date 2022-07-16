<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Infrastructure\Repositories\VillageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(VillageRepositoryInterface::class, function ($app) {
            return new VillageRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
