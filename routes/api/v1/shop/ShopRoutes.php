<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:shop')->group(function(){
    Route::get('/','Get');
    Route::put('/','Update');
    Route::put('/contact','UpdateContact');
    Route::post('/update_menu','UpdateMenu');
    Route::post('/update_logo','UpdateLogo');
    

});