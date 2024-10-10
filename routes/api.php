<?php

use Illuminate\Support\Facades\Route;

Route::prefix('product')->group(function () {
    Route::get('/', ['uses' => 'ProductController@get_products']);
    Route::get('/{id}', ['uses' => 'ProductController@get_by_id']);
    Route::post('/add', ['uses' => 'ProductController@add']);
    Route::patch('/update', ['uses' => 'ProductController@update']);
    Route::delete('/delete', ['uses' => 'ProductController@delete']);
});
