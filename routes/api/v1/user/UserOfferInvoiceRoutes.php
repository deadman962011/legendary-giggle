<?php

use Illuminate\Support\Facades\Route;


Route::get('/previous','GetPreviousOffers');
Route::post('/scan','Scan');
Route::get('get_by_offer_id/{offer_id}','GetOfferInvoiceByOfferId');
Route::get('/{id}','GetOfferInvoice');


?>