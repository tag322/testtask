<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;

Route::post('/order/register', 'App\Http\Controllers\OrdersController@RegisterOrder');
Route::post('/order/book', 'App\Http\Controllers\OrdersController@BookOrder');
