<?php

use Illuminate\Support\Facades\Route;


Route::middleware('guest:user')->group(function(){
    Route::post('/','Authenticate');
    Route::post('/validate','ValidateLink')->middleware('validated_user_location');
    Route::post('/register/complete','CompleteRegister')->middleware('validated_user_location');
});

Route::middleware('auth:user')->group(function(){
    Route::get('/profile','Profile');
    Route::post('/profile','UpdateProfile');
    Route::post('/profile/update-image','UpdateProfileImage');
    Route::get('/logout','Logout')->middleware('auth:user');
});




?>