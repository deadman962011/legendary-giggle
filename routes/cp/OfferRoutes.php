<?php
use Illuminate\Support\Facades\Route;



Route::get('/list','List')->name('offer.list');

Route::get('/new','Create')->name('offer.create');

Route::post('/new','Store')->name('offer.store');

Route::get('/{id}','Edit')->name('offer.edit');

Route::put('/{id}','Update')->name('offer.update');

Route::delete('/{id}','Delete')->name('offer.delete');

?>