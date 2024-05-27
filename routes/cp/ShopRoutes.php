<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('shop.list');

Route::get('/new','Create')->name('shop.create');

Route::post('/new','Store')->name('shop.store');

Route::get('/{id}','Show')->name('shop.show');

Route::put('/{id}/status','UpdateStatus')->name('shop.update_status');

?>
