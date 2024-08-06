<?php
use Illuminate\Support\Facades\Route;



Route::get('/list','List')->name('plan.list');

Route::get('/new','Create')->name('plan.create');

Route::post('/new','Store')->name('plan.store');

Route::get('/{id}','Edit')->name('plan.edit');

Route::put('/{id}','Update')->name('plan.update');

Route::put('/{id}/status','UpdateStatus')->name('plan.update_status');

Route::delete('/{id}','Delete')->name('plan.delete');

?>