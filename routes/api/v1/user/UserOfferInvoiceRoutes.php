<?php

use Illuminate\Support\Facades\Route;


Route::get('/previous','GetPreviousOffers');
Route::post('/scan','Scan');
Route::get('/{id}','GetOfferInvoice');

?>