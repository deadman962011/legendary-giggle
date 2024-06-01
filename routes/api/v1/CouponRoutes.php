<?php

use Illuminate\Support\Facades\Route;

Route::get('/','Get');


Route::get('/redeem_history','GetCouponRedeemHistory')->middleware('auth:user');


Route::get('/{id}','GetCouponDetails');


Route::post('/{id}/redeem','RedeemCoupon')->middleware('auth:user');



?>