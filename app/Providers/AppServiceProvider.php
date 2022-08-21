<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Services\VillageDetailsService;
use Packages\Domain\Services\VillagePermissionService;
use Packages\Domain\Services\VillageService;
use Packages\Infrastructure\Repositories\VillageDetailsRepository;
use Packages\Infrastructure\Repositories\VillageMemberInfoRepository;
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
        $this->app->singleton(VillageService::class, function ($app) {
            return new VillageService(
                new VillageRepository(),
                new VillageMemberInfoRepository()
            );
        });
        $this->app->singleton(VillagePermissionService::class, function ($app) {
            return new VillagePermissionService(
                new VillageRepository()
            );
        });
        $this->app->singleton(VillageDetailsService::class, function ($app) {
            return new VillageDetailsService(
                new VillageDetailsRepository()
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
