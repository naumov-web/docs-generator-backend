<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/dev-tools')->group(function () {
    Route::get('/docs', 'Web\DevToolsController@docs');
    Route::get('/swagger-file', 'Web\DevToolsController@file');
});
