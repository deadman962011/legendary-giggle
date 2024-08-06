<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get')->middleware('validated_user_location');
Route::post('/search','Search');
Route::get('/search_history','GetSearchHistory');
Route::get('/{id}','GetOffer');
Route::get('/{id}/offer_cashback_recived','OfferCashbackRecived');

?>