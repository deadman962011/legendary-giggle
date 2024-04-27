<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:shop')->group(function(){
    Route::get('/','List');
    Route::post('/','Store');
    Route::get('/{id}','Get');
    // Route::post('/validate','ValidateLink');
    // Route::post('/register/complete','CompleteRegister');
    // Route::post('/login','Login');
});


?>