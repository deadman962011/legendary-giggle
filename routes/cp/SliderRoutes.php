<?php
use Illuminate\Support\Facades\Route;


// Route::get('/list','List')->name('slider.list');



Route::get('/{name}','Get')->name('slider.get');

Route::post('/{name}','Update')->name('slider.update');

Route::put('/{id}/status','UpdateStatus')->name('slider.update_status');

Route::put('/{id}/slide_status','updateSlideStatus')

// Route::post('/{id}/add_slide','addSlide');

// Route::post('/{id}/remove_slide','removeSlide');


// Route::get('/new','Create')->name('slider.create');

// Route::post('/new','Store')->name('slider.store');


?>
