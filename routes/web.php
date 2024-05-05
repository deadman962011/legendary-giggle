<?php

use App\Http\Controllers\cp\LanguageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

Route::middleware('auth:web')->group(function(){
    Route::get('/', function () {
        return view('welcome',['action'=>'test','token'=>'1234']);
    })->name('home');

});


Route::post('language_change',[LanguageController::class,'change'])->name('language.change');



// R