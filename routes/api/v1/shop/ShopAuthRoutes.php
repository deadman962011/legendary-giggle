<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest:shop')->group(function(){
    Route::post('/login','Login');
    Route::post('/register','Register');
});

Route::get('/logout','Logout')->middleware('auth:shop');



?>