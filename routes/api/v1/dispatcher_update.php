<?php

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| These routes are prefixed with 'api/v1'.
| These routes use the root namespace 'App\Http\Controllers\Api\V1'.
|
 */
use App\Base\Constants\Auth\Role;

/**
 * These routes are prefixed with 'api/v1'.
 * These routes use the root namespace 'App\Http\Controllers\Api\V1\User'.
 * These routes use the middleware group 'auth'.
 */

Route::prefix('dispatcher_update')->namespace('User')->middleware('auth')->group(function () {
    Route::middleware(role_middleware(Role::DISPATCHER))->group(function () {
        Route::post('dispatcher-profile','ProfileController@updateDispatcherProfile');
    });
});

