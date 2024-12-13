<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => '', 'prefix' => ''], function () {
    Route::middleware('api')->group(base_path('routes/api/v1.php'));
    //Route::prefix('v2')->name('v2')->group(base_path('routes/api_v2.php'));
});
