<?php

use App\Http\Controllers\DisplayController;


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


Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/stockmenu', 'DisplayController@stockMenu')->name('stock.menu');


    Route::get('/contentview', 'DisplayController@viewContent')->name('view.content');

    Route::post('/contentview', 'DisplayController@getContent');

    Route::get('/arrivalmenu', 'DisplayController@arrivalMenu')->name('arrival.menu');

    Route::get('/arrivalmenu{id}', 'RegistrationController@deleteStock')->name('delete.stock');

    Route::get('/registerarrival', 'DisplayController@registerArrivalForm')->name('register.arrival.form');

    Route::post('/registerarrival', 'RegistrationController@registerArrival');

    Route::get('/registerarrival{id}', 'RegistrationController@decisionArrival')->name('decision.arrival');

    Route::get('/registeruser', 'DisplayController@registerUserForm')->name('register.user.form');

    Route::post('/registeruser', 'RegistrationController@registerUser');

    Route::get('/registeritem', 'DisplayController@registerItemForm')->name('register.item.form');

    Route::post('/registeritem', 'RegistrationController@registerItem');



});


