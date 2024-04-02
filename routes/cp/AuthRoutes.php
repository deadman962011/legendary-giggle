<?php

use App\Http\Controllers\cp\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->middleware('guest:web')->group(function(){
    Route::prefix('login')->group(function(){
        Route::get('/','Get')->name('login');
        Route::post('/','Post');
    });
});


// R