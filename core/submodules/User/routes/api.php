<?php

/**
 *------------------------------------------------------------------------------
 * User API Routes
 *------------------------------------------------------------------------------
 *
 * The API routes for users.
 *
 */

Route::group(['prefix' => 'v1'], function () {
    Route::api('users', 'UserApiController');
    // Route::get('users/all', 'UserController@getAll')->name('users.all');
    // Route::get('users/find', 'UserController@postFind')->name('users.find');
    // Route::get('users/search', 'UserController@postFind')->name('users.search');
    // Route::get('users/{user}', 'UserController@getShow')->name('users.show');
    // Route::post('users/save', 'UserController@postStore')->name('users.save');
    // Route::post('users/store', 'UserController@postStore')->name('users.store');
    // Route::delete('users/{user}/destroy', 'UserController@deleteDestroy')->name('users.destroy');

    /**
     *--------------------------------------------------------------------------
     * Authentication
     *--------------------------------------------------------------------------
     *
     */
    Route::post('login', 'LoginApiController@login')
        ->middleware(['api', 'preflight', 'cors'])
        ->name('login.login');
    Route::post('authenticate', 'LoginApiController@authenticate')
        ->middleware(['api', 'preflight', 'cors'])
        ->name('login.authenticate');
});
