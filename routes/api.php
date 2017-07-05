<?php
Route::group(['middleware' => 'cors'], function () {

    Route::post('/auth/login', 'Auth\AuthController@login')->name('auth.login');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/users', 'UserController@store')->name('users.store');
        Route::get('/users/{user}', 'UserController@show')->name('users.show');
        Route::put('/users/{user}', 'UserController@update')->name('users.update');
        Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');
        Route::get('/users', 'UserController@index')->name('users.index');

    });
});