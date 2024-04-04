<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest:shop')->group(function(){
    Route::post('/','Authenticate');
    Route::post('/validate','Validate');
    Route::post('/register/complete','CompleteRegister');
    // Route::post('/login','Login');
});

Route::get('/logout','Logout')->middleware('auth:shop');



?>