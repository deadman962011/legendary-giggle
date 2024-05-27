<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('coupon.list');

Route::get('/new','Create')->name('coupon.create');

Route::post('/new','Store')->name('coupon.store');

Route::get('/{id}','Edit')->name('coupon.edit');

Route::put('/{id}','Update')->name('coupon.update');

Route::put('/{id}/status','UpdateStatus')->name('coupon.update_status');

Route::delete('/{id}','Delete')->name('coupon.delete');

?>