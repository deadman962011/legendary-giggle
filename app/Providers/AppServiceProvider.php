<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\ShopWalletTransaction;
use App\Models\User;
use App\Models\UserWalletTransaction;
use App\Observers\ShopWalletTransactionObserver;
use App\Observers\UserWalletTransactionObserver; 
use App\Services\UserService;
use App\Services\ApprovalService;
use App\Services\OfferService;
use App\Services\ShopService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use ReferralService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(ApprovalService::class, function ($app) {
            return new ApprovalService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
        });

        $this->app->singleton(OfferService::class, function ($app) {
            return new OfferService();
        });
        
        $this->app->singleton(ReferralService::class, function ($app) {
            return new ReferralService();
        });
        
        $this->app->singleton(ShopService::class, function ($app) {
            return new ShopService();
        });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        UserWalletTransaction::observe(UserWalletTransactionObserver::class);
        ShopWalletTransaction::observe(ShopWalletTransactionObserver::class);

        View::composer('*', function ($view) {
            $languages=Language::where('isDeleted',0)->where('status',true)->get();
            $view->with('languages',$languages);
        });


    }
}
