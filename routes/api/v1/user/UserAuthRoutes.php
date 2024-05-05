<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest:user')->group(function(){
    Route::post('/','Authenticate');
    Route::post('/validate','ValidateLink');
    Route::post('/register/complete','CompleteRegister');
});

Route::middleware('auth:user')->group(function(){
    Route::get('/profile','Profile');
    Route::post('/profile','UpdateProfile');
    Route::post('/profile/update-image','UpdateProfileImage');
    Route::get('/logout','Logout')->middleware('auth:user');
});




?>