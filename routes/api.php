<?php
Route::group(['middleware' => 'cors'], function () {

    Route::post('/auth/login', 'Auth\AuthController@login')->name('auth.login');

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::get('/auth/me', 'Auth\AuthController@me')->name('auth.me');
        Route::delete('/auth/logout', 'Auth\AuthController@logout')->name('auth.logout');

        Route::group(['middleware' => ['permission:manage-user']], function () {
            Route::post('/users', 'UserController@store')->name('users.store');
            Route::get('/users/{user}', 'UserController@show')->name('users.show');
            Route::put('/users/{user}', 'UserController@update')->name('users.update');
            Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');
            Route::get('/users', 'UserController@index')->name('users.index');
        });

        Route::group(['middleware' => 'permission:create-request'], function () {
            Route::post('/requests', 'RequestController@store')->name('request.store');
        });
    });
});