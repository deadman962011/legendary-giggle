<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:shop')->group(function () {
    Route::get('/','GetDays');
    Route::put('/', 'ToggleDay');
    Route::post('/slot', 'AddSlot');
    Route::delete('/slot', 'RemoveSlot');
    Route::put('/slot','UpdateSlot');
});
