<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:shop')->group(function(){
    Route::get('/','List');
    Route::post('/','Store');
    Route::get('/{id}','Get');
    Route::post('/{id}/cancel_invoice','cancelOfferInvoice'); 
});

?>