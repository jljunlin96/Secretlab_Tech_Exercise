<?php
#
/*
|--------------------------------------------------------------------------
| API Routes
| Naming V1 for Versioning and Flexibility
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\KeyValueControllers;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '','as'=>''], function () {
    Route::group(['as'=>'key.value.',
        'controller'=> KeyValueControllers::class], function () {
        Route::get('object/get_all_records', 'index')->name('index');
        Route::get('object/{key}', 'show')->name('show');
        Route::post('object', 'store')->name('store');
    });
});
