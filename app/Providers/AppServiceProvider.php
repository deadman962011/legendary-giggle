<?php

namespace App\Providers;

use App\Services\UserService;
use App\Services\ApprovalService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        
        $this->app->singleton(ApprovalService::class, function ($app) {
            return new ApprovalService();
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
