<?php

namespace App\Providers;

// use App\Http\Controllers\api\user\AuthController;

use App\Http\Controllers\api\ApiCategoryController;
use App\Http\Controllers\api\ApiSliderController;
use App\Http\Controllers\api\ApiZoneController;
use App\Http\Controllers\api\ApiSettingController;
use App\Http\Controllers\api\shop\ShopAuthController;
use App\Http\Controllers\api\shop\ShopOfferController;
use App\Http\Controllers\api\shop\ShopStaffController;
use App\Http\Controllers\api\user\ApiOfferController;
use App\Http\Controllers\api\user\ApiOfferFavoriteController;

use App\Http\Controllers\api\user\UserAuthController;
use App\Http\Controllers\cp\AizUploadController;
use App\Http\Controllers\cp\ApprovalController;
use App\Http\Controllers\cp\CategoryController;
use App\Http\Controllers\cp\OfferController;
use App\Http\Controllers\cp\RoleController;
use App\Http\Controllers\cp\SettingController;
use App\Http\Controllers\cp\ShopController;
use App\Http\Controllers\cp\SliderController;
use App\Http\Controllers\cp\StaffController;
use App\Http\Controllers\cp\ZoneController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware(['api','api.localization'])
                ->prefix('api/v1')
                ->group(function () {
                    Route::prefix('category')->controller(ApiCategoryController::class)->group(base_path('routes/api/v1/CategoryRoutes.php'));
                    Route::prefix('slider')->controller(ApiSliderController::class)->group(base_path('routes/api/v1/SliderRoutes.php'));
                    Route::prefix('zone')->controller(ApiZoneController::class)->group(base_path('routes/api/v1/ZoneRoutes.php'));
                    Route::prefix('setting')->controller(ApiSettingController::class)->group(base_path('routes/api/v1/SettingRoutes.php'));
                    Route::prefix('user')->group(function () {
                        Route::prefix('auth')->controller(UserAuthController::class)->group(base_path('routes/api/v1/user/UserAuthRoutes.php'));
                        Route::prefix('offer')->controller(ApiOfferController::class)->group(base_path('routes/api/v1/user/UserOfferRoutes.php'));
                        
                        Route::middleware('auth:user')->group(function(){
                            Route::prefix('offer_favorite')->controller(ApiOfferFavoriteController::class)->group(base_path('routes/api/v1/user/UserOfferFavoriteRoutes.php'));
                        });
                    
                    });

                    Route::prefix('shop')->group(function () {
                        Route::prefix('auth')->controller(ShopAuthController::class)->group(base_path('routes/api/v1/shop/ShopAuthRoutes.php'));
                        Route::middleware('auth:shop')->group(function () {
                            Route::prefix('staff')->controller(ShopStaffController::class)->group(base_path('routes/api/v1/shop/ShopStaffRoutes.php'));
                            Route::prefix('offer')->controller(ShopOfferController::class)->group(base_path('routes/api/v1/shop/ShopOfferRoutes.php'));
                        });
                    });
                });

            Route::middleware('web')->group(base_path('routes/web.php'));
            Route::middleware('web')->group(base_path('routes/cp/AuthRoutes.php'));

            Route::middleware(['web', 'auth:web'])->group(function () {
                Route::prefix('approval')->controller(ApprovalController::class)->group(base_path('routes/cp/ApprovalRoutes.php'));
                Route::prefix('shop')->controller(ShopController::class)->group(base_path('routes/cp/ShopRoutes.php'));
                Route::prefix('category')->controller(CategoryController::class)->group(base_path('routes/cp/CategoryRoutes.php'));
                Route::prefix('offer')->controller(OfferController::class)->group(base_path('routes/cp/OfferRoutes.php'));
                Route::prefix('slider')->controller(SliderController::class)->group(base_path('routes/cp/SliderRoutes.php'));
                Route::prefix('zone')->controller(ZoneController::class)->group(base_path('routes/cp/ZoneRoutes.php'));
                Route::prefix('staff')->controller(StaffController::class)->group(base_path('routes/cp/StaffRoutes.php'));
                Route::prefix('role')->controller(RoleController::class)->group(base_path('routes/cp/RoleRoutes.php'));



                Route::prefix('setting')->controller(SettingController::class)->group(base_path('routes/cp/SettingRoutes.php'));
                Route::prefix('aiz-uploader')->controller(AizUploadController::class)->group(base_path('routes/cp/UploaderRoutes.php'));
            });
        });
    }
}
