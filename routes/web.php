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
Route::match(['get', 'post'], '/admin/admin_register', 'AdminController@register');
Route::get('/logout', 'AdminController@logout');

Auth::routes();

Route::get('/website', 'WebsiteController@index')->name('website');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/account_settings', 'AdminController@account_settings');
    Route::post('/admin/update_password', 'AdminController@update_password');

    Route::match(['get', 'post'], '/admin/categories', 'CategoryController@index');
    Route::get('/admin/categories/change_status/{id}/{status}', 'CategoryController@change_status');
    Route::match(['get', 'post'], '/admin/categories/edit/{id}', 'CategoryController@edit');
    Route::get('/admin/categories/delete/{id}', 'CategoryController@delete');
    Route::match(['get', 'post'], '/admin/categories/add', 'CategoryController@add'); 
}); 
