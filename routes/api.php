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
Route::post('/_delete_assets', 'AssetController@deleteAssets')->name('delete.assets');
Route::post('/_update_assets', 'AssetController@updateAssets')->name('update.assets');

Route::post('/_create_media', 'MediaController@createMedia')->name('create.media');
Route::post('/_fetch_media', 'MediaController@fetchMedia')->name('fetch.media');
Route::post('/_search_media', 'MediaController@searchMedia')->name('search.media');
Route::post('/_delete_media', 'MediaController@deleteMedia')->name('delete.media');
Route::post('/_update_media', 'MediaController@updateMedia')->name('update.media');

Route::post('/_post_marker', 'MarkerController@postMarker')->name('post.marker');
Route::post('/_fetch_marker', 'MarkerController@fetchMarker')->name('fetch.marker');
Route::post('/_fetch_markers', 'MarkerController@fetchMarkers')->name('fetch.markers');

Route::post('/_post_pattern', 'MarkerController@postPattern')->name('post.pattern');

Route::post('/_fetch_experience', 'MarkerController@fetchExperience')->name('fetch.experience');
Route::post('/_post_experience', 'MarkerController@postExperience')->name('post.experience');
Route::post('/_eidt_post_experience', 'MarkerController@editPostExperience')->name('edit.post.experience');