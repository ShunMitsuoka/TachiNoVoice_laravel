<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Domain\Interfaces\Repositories\HostRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageMemberRepositoryInterface;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Services\VillageService;
use Packages\Infrastructure\Repositories\HostRepository;
use Packages\Infrastructure\Repositories\VillageMemberInfoRepository;
use Packages\Infrastructure\Repositories\VillageMemberRepository;
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
        $this->app->singleton(HostRepositoryInterface::class, function ($app) {
            return new HostRepository();
        });
        $this->app->singleton(VillageMemberRepositoryInterface::class, function ($app) {
            return new VillageMemberRepository();
        });
        $this->app->singleton(VillageService::class, function ($app) {
            return new VillageService(
                new VillageRepository(),
                new VillageMemberInfoRepository()
            );
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
