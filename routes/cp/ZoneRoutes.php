<?php
use Illuminate\Support\Facades\Route;



Route::get('/list','List')->name('zone.list');

Route::get('/new','Create')->name('zone.create');

Route::post('/new','Store')->name('zone.store');

Route::get('/get-coordinates/{id}','GetCoordinate');

Route::get('/{id}','Edit')->name('zone.edit');

Route::put('/{id}','Update')->name('zone.update');

Route::put('/{id}/status','UpdateStatus')->name('zone.update_status');

Route::delete('/{id}','Delete')->name('zone.delete');



?>