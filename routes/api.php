<?php

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/users', 'UserController@store')->name('users.create');
