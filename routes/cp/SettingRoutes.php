<?php
use Illuminate\Support\Facades\Route;



Route::get('/{section}','List')->name('setting.list');

Route::post('/','Update')->name('setting.update');

// Route::get('/new','Create')->name('offer.create');

// Route::post('/new','Store')->name('offer.store');

// Route::get('/{id}','Edit')->name('offer.edit');

// Route::put('/{id}','Update')->name('offer.update');

// Route::put('/{id}/status','UpdateStatus')->name('offer.update_status');

// Route::delete('/{id}','Delete')->name('offer.delete');

?>