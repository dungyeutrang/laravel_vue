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
    return view('welcome');
});

Route::get('/logout','Auth\LoginController@logout');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('admin');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')->name('category.list');
        Route::get('/getData', 'CategoryController@getData')->name('category.getData');
        Route::get('/delete/{id}', 'CategoryController@delete')->name('category.delete');
        Route::get('/edit/{id?}', 'CategoryController@edit')->name('category.edit');
        Route::get('/getRecord/{id}', 'CategoryController@getRecord')->name('category.getRecord');
    });
});

Route::get('/home', 'HomeController@index');
