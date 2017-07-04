<?php

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/users', 'UserController@index')->name('users.index');
Route::post('/users', 'UserController@store')->name('users.create');
Route::put('/users/{user}', 'UserController@update')->name('users.edit');
