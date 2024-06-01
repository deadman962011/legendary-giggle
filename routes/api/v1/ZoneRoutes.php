<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get');



Route::get('/{id}/districts','GetDistricts')->name('api.zone.get_destricts');


?>