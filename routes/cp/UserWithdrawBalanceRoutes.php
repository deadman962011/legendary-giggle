<?php
use Illuminate\Support\Facades\Route;


Route::get('/list','List')->name('user_withdraw_balance_request.list');

Route::get('/list_bulk','ListBulk')->name('user_withdraw_balance_request.list_bulk');

Route::post('/update_bulk','UpdateBulk')->name('user_withdraw_balance_request.update_bulk');

Route::get('/{id}','Show')->name('user_withdraw_balance_request.show');

Route::post('/{id}','Update')->name('user_withdraw_balance_request.update');




// Route::get('/new','Create')->name('staff.create');

// Route::post('/new','Store')->name('staff.store');

// Route::get('/{id}','Edit')->name('staff.edit');

// Route::put('/{id}','Update')->name('staff.update');

// Route::put('/{id}/status','UpdateStatus')->name('staff.update_status');

// Route::delete('/{id}','Delete')->name('staff.delete');

?>