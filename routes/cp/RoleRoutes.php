<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('role.list');

Route::get('/new','Create')->name('role.create');

Route::post('/new','Store')->name('role.store');

Route::get('/{id}','Edit')->name('role.edit');

Route::put('/{id}','Update')->name('role.update');

Route::put('/{id}/status','UpdateStatus')->name('role.update_status');

Route::delete('/{id}','Delete')->name('role.delete');

?>