<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest:user')->group(function(){
    Route::post('/','Authenticate');
    Route::post('/validate','ValidateLink');
    Route::post('/register/complete','CompleteRegister');
});

Route::get('/logout','Logout')->middleware('auth:user');



?>