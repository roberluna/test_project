<?php

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



Route::get('/users', ['as' => 'home', 'uses' => 'HomeController@index']);


Route::post('/users/destroy', 'HomeController@destroy');

Route::post('/users/store', 'HomeController@store');

Route::get('/users/show/{id}', 'HomeController@show');

Route::post('/users/update', 'HomeController@update');


Route::get('/{any?}', function () {
    return view('home');
})->name('basepath')
->where('any', '.*');