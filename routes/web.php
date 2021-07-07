<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register'=>true,
    'login'=>false
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login-request', 'CustomLoginController@loginRequest')->name('login.request');
Route::post('/login-request-email', 'CustomLoginController@loginRequestEmail')->name('login.request.email');
Route::get('/login-link/{token}', 'CustomLoginController@loginLink')->name('login.link');