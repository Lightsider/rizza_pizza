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

Route::get('/setCurrency/{currency}', 'PublicController@setCurrency')->name('setCurrency');

Route::group(['middleware' => ['cart','currency']], function () {
    Route::get('/', 'PublicController@index')->name('index');

    Route::get('/cart', 'CartController@view')->name('cart');
    Route::post('/addCart', 'CartController@addCart')->name('addCart');
    Route::post('/removeCart', 'CartController@removeCart')->name('removeCart');

    Route::get('/formOrder', 'PublicController@formOrder')->name('formOrder');
    Route::post('/saveOrder', 'PublicController@saveOrder')->name('saveOrder');

    Route::get('/thankYou', 'PublicController@thankYou')->name('thankYou');


    Auth::routes();

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('user', 'UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
    });
});

