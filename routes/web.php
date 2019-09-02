<?php

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
    return redirect('/ResoSystem/login');
});

//Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('ResoSystem')->group(function() {
    Route::match(['get', 'post'], '/home', 'ResoSystemController@home')->name('reso.home');
    Route::match(['get', 'post'], '/books', 'ResoSystemController@books')->name('reso.books');
    Route::match(['get', 'post'], '/movies', 'ResoSystemController@movies')->name('reso.movies');
    Route::match(['get', 'post'], '/musics', 'ResoSystemController@musics')->name('reso.musics');
    Route::match(['get', 'post'], '/addToCart/{id}/{name}', 'ResoSystemController@addToCart')->where(['id' => '[0-9]+', 'name' => '[A-Za-z]+'])->name('reso.addToCart');
    Auth::routes();
});