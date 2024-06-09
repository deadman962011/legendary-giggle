<?php
use Illuminate\Support\Facades\Route;

Route::get('/list','List')->name('shop_commission_payment.list');

Route::get('/{id}','Show')->name('shop_commission_payment.show');
 
Route::post('/{id}','Update')->name('shop_commission_payment.update'); 

?>