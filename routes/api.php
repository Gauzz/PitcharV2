<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/_create_assets', 'AssetController@createAssets')->name('create.assets');
Route::post('/_fetch_assets', 'AssetController@fetchAssets')->name('fetch.assets');
Route::post('/_search_assets', 'AssetController@searchAssets')->name('search.assets');

Route::post('/_create_media', 'MediaController@createmedia')->name('create.media');
Route::post('/_fetch_media', 'MediaController@fetchmedia')->name('fetch.media');
Route::post('/_search_media', 'MediaController@searchmedia')->name('search.media');

