<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/uploads/{pathToFile}', function ($pathToFile) {
    return url('uploads/'.$pathToFile);
})->middleware('cors');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/onboarding', function () {
    return view('auth.onboarding');
});



Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');