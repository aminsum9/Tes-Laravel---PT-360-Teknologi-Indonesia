<?php

use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function () {
    Route::get('/', ['uses' => 'ProductController@get_products']);
    Route::get('/{id}', ['uses' => 'ProductController@get_by_id']);
    Route::post('/add', ['uses' => 'ProductController@add']);
    Route::post('/update', ['uses' => 'ProductController@update']);
    Route::post('/delete', ['uses' => 'ProductController@delete']);
});
