<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get');

Route::get('/all','GetAll');

Route::get('/permissions','GetPermissions');

Route::get('/{id}','GetRole');

Route::post('/{id}','Update');

Route::post('/','Store');



?>