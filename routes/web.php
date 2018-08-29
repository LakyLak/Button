<?php

// use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|rid
*/



Route::match(['get', 'post'], '/admin', 'AdminController@login')->name('login');
Route::match(['get', 'post'], '/admin/admin_register', 'AdminController@register');
Route::get('/logout', 'AdminController@logout');

// Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/account_settings', 'AdminController@account_settings');
    Route::post('/admin/update_password', 'AdminController@update_password');

    Route::match(['get', 'post'], '/admin/categories', 'CategoryController@index');
    Route::get('/admin/categories/activate/{id}/{status}', 'CategoryController@activate');
    Route::match(['get', 'post'], '/admin/categories/edit/{id}', 'CategoryController@edit');
    Route::get('/admin/categories/delete/{id}', 'CategoryController@delete');
    Route::match(['get', 'post'], '/admin/categories/add', 'CategoryController@add'); 

    Route::post('/admin/settings/grid_view_settings/{id}', 'AdminGridSettingsController@grid_view_settings');
    Route::post('/admin/settings/reset_grid_view_settings/{id}', 'AdminGridSettingsController@reset_grid_view_settings');
});

Route::get('/', function () {
    return view('welcome');
});