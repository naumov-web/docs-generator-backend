<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->name('v1.')->group(function (){
    Route::prefix('auth')->group(function () {
        Route::post('register', 'Api\V1\AuthController@register')
            ->name('auth.register');
    });
});
