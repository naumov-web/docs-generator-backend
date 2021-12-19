<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('locale')->group(function() {
    Route::prefix('v1')->name('v1.')->group(function (){
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('register', 'Api\V1\AuthController@register')
                ->name('register');
            Route::post('login', 'Api\V1\AuthController@login')
                ->name('login');
        });

        Route::middleware(['auth.jwt'])->group(function(){
            Route::prefix('account')->name('account.')->group(function (){
                Route::prefix('user')->name('user.')->group(function () {
                    Route::get('', 'Api\V1\UserController@show')
                        ->name('show');
                    Route::put('', 'Api\V1\UserController@update')
                        ->name('update');
                });

                Route::prefix('document-templates')->name('document_templates.')->group(function () {
                    Route::post('', 'Api\V1\DocumentTemplatesController@create')
                        ->name('create');
                });
            });
        });
    });
});
