<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('category.list');

Route::get('/new','Create')->name('category.create');

Route::post('/new','Store')->name('category.store');

Route::get('/{id}','Edit')->name('category.edit');

Route::put('/{id}','Update')->name('category.update');

Route::delete('/{id}','Delete')->name('category.delete');

?>