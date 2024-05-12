<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('notification.list');

Route::get('/new','Create')->name('notification.create');

Route::post('/new','Store')->name('notification.store');

?>