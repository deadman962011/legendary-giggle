<?php
use Illuminate\Support\Facades\Route;



Route::get('/list','List')->name('deposit_bank_account.list');

Route::get('/new','Create')->name('deposit_bank_account.create');

Route::post('/new','Store')->name('deposit_bank_account.store');

Route::get('/{id}','Edit')->name('deposit_bank_account.edit');

Route::put('/{id}','Update')->name('deposit_bank_account.update');

Route::put('/{id}/status','UpdateStatus')->name('deposit_bank_account.update_status');

Route::delete('/{id}','Delete')->name('deposit_bank_account.delete');

?>