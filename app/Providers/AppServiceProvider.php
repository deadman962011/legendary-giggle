<?php

namespace App\Providers;

use App\Models\Language;
use App\Services\UserService;
use App\Services\ApprovalService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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

        View::composer('*', function ($view) {

            $languages=Language::where('isDeleted',0)->where('status',true)->get();
            $view->with('languages',$languages);

        });


    }
}
