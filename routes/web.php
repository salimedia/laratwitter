<?php

use Atymic\Twitter\Twitter;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'TwitterController@index')->name('index');
Route::get('/twitter', 'TwitterController@twitter_oauth');
Route::get('/twitter/callback', 'TwitterController@callback')->name('twitter.callback');

