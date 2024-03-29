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


Route::get('/', 'Web\WheatherController@index')->name('main');

$data = [
    'prefix' => 'admin',
    'namespace' => 'Admin',
//    'middleware' => 'auth'
];
Route::group($data, function () {

    Route::get('/', function () {
        return view('layouts.admin');
    })->name('panel');
    Route::resource('orders', 'OrderController')->except([
        'show', 'create', 'store', 'destroy'
    ]);

});