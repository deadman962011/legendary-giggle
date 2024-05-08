<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('staff.list');

Route::get('/new','Create')->name('staff.create');

Route::post('/new','Store')->name('staff.store');

Route::get('/{id}','Edit')->name('staff.edit');

Route::put('/{id}','Update')->name('staff.update');

Route::put('/{id}/status','UpdateStatus')->name('staff.update_status');

Route::delete('/{id}','Delete')->name('staff.delete');

?>