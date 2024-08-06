<?php
use Illuminate\Support\Facades\Route;

Route::get('/list','List')->name('shop_subscription_request.list');

Route::get('/{id}','Show')->name('shop_subscription_request.show');
 
Route::post('/{id}','Update')->name('shop_subscription_request.update'); 

?>