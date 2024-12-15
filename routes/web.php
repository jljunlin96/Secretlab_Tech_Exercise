<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => '', 'prefix' => ''], function () {
    Route::get('/', function () {
        return view('welcome');
    });
});
