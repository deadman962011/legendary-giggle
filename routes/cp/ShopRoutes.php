<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('shop.list');

Route::get('/new','Create')->name('shop.create');

Route::post('/new','Store')->name('shop.store');

Route::put('/{id}/status','UpdateStatus')->name('shop.update_status');

?>
