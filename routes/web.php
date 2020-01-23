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

//Community service routes for admin
Route::post("add-community-service","CommunityServiceController@store");
Route::post("delete-community-service","CommunityServiceController@destroy");
Route::get("service-info/{id}","CommunityServiceController@show");
Route::get("service-edit/{id}","CommunityServiceController@edit");
Route::post("update-community-service","CommunityServiceController@store");




Route::post("add-community-service-user","UserServiceController@store");
Route::post("delete-community-service-user","UserServiceController@destroy");

//User routes for admin
Route::get("user-info/{id}","UserController@show");
Route::post("user-delete","UserController@destroy");


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
