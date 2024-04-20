<?php
use Illuminate\Support\Facades\Route;


Route::get('/','List')->name('approval.list');
Route::get('/{id}','Show')->name('approval.show');
Route::post('/handle','Handle')->name('approval.handle');
// Route::post('/approve','Approve')->name('approval.approve');
// Route::post('/reject','Reject')->name('approval.reject');

?>