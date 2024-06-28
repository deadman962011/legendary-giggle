<?php

use App\Models\ShopAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/','Get');

Route::post('/','Store');

Route::get('/{id}','GetStaff');

Route::post('/{id}','Update');

?>