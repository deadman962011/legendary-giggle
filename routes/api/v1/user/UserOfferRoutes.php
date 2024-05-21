<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get')->middleware('validated_user_location');
Route::get('/{id}','GetOffer');

?>