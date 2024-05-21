<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:shop')->group(function(){
    Route::get('/','Get');
    Route::put('/','Update');
    Route::put('/contact','UpdateContact');
});