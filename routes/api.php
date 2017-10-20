<?php
Route::group(['middleware' => 'cors'], function () {

    Route::post('/auth/login', 'Auth\AuthController@login')
         ->name('auth.login');

    Route::group(['middleware' => 'jwt.auth'], function () {

        Route::get('/auth/me', 'Auth\AuthController@me')
             ->name('auth.me');
        Route::delete('/auth/logout', 'Auth\AuthController@logout')
             ->name('auth.logout');

        Route::group(['middleware' => 'role:admin|secretary'], function () {
            // Users
            Route::post('/users', 'UserController@store')
                 ->name('users.create');
            Route::get('/users/{user}', 'UserController@show')
                 ->name('users.view');
            Route::put('/users/{user}', 'UserController@update')
                 ->name('users.update');
            Route::delete('/users/{user}', 'UserController@destroy')
                 ->name('users.delete');
            Route::get('/users', 'UserController@index')
                 ->name('users.index');
            Route::post('/users/{user}/department-chief', 'MandateController@store')
                 ->name('users.department-chief');

            // Requests
            Route::patch('/removal-requests/{removal_request}/register-voting-result', 'RemovalRequestController@registerVotingResult')
                 ->name('removal-request.register-voting-result');
            Route::post('/removal-requests/{removal_request}/register-ct-opinion', 'OpinionController@registerCt')
                 ->name('removal-request.register-ct-opinion');
            Route::post('/removal-requests/{removal_request}/register-prppg-opinion', 'OpinionController@registerPrppg')
                 ->name('removal-request.register-prppg-opinion');
            Route::patch('/removal-requests/{removal_request}/archive', 'RemovalRequestController@archive')
                 ->name('removal-request.archive');
        });

        Route::group(['middleware' => 'role:admin|professor'], function () {
            // Requests
            Route::get('/removal-requests', 'RemovalRequestController@index')
                 ->name('removal-request.index');
            Route::get('/removal-requests/{removal_request}', 'RemovalRequestController@show')
                 ->name('removal-request.show');
            Route::post('/removal-requests', 'RemovalRequestController@store')
                 ->name('removal-request.create');
            Route::patch('/removal-requests/{removal_request}/cancel', 'RemovalRequestController@cancel')
                 ->name('removal-request.cancel');
            Route::post('/removal-requests/{removal_request}/manifest-against', 'OpinionController@manifestAgainst')
                 ->name('removal-request.manifest-against');
            Route::patch('/removal-requests/{removal_request}/choose-rapporteur', 'RemovalRequestController@chooseRapporteur')
                 ->name('removal-request.choose-rapporteur');
            Route::post('/removal-requests/{removal_request}/defer-opinion', 'OpinionController@defer')
                 ->name('removal-request.defer-opinion');
        });

        Route::prefix('me')
             ->group(function () {
                 Route::get('/removal-requests', 'RemovalRequestController@meIndex')
                      ->name('me.removal-request.index');
             });
    });
});