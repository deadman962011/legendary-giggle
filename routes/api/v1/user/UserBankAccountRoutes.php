<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get');

Route::post('/','Store');

Route::get('/{id}','GetBankAccountDetails');

Route::put('/{id}','Update');

?>