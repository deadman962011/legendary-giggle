<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get')->middleware('validated_user_location');
Route::get('/search','Search');
Route::get('/search_history','GetSearchHistory');
Route::get('/{id}','GetOffer');

?>