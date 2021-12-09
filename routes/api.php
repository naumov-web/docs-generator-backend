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
        Route::prefix('projects')->name('projects.')->group(function () {
            Route::post('', 'Api\V1\ProjectsController@create')->name('create');
        });
    });
});
