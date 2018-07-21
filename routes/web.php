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

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/admin', 'AdminController@login');
Route::get('/logout', 'AdminController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/account_settings', 'AdminController@account_settings');
    //  Route::post('/admin/check_password', 'AdminController@check_password');
    Route::post('/admin/update_password', 'AdminController@update_password');
    // Route::match(['get', 'post'], '/admin/update_password', 'AdminController@update_password');
}); 