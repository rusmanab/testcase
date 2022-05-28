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

Route::get('/', 'HomeController@index');
Route::get('home','HomeController@index')->name('home');
Route::get('category','CategoryController@index')->name('category');
Route::post('category/save','CategoryController@save')->name('category.save');
Route::get('category/gettable','CategoryController@getTable')->name('category.gettable');
Route::post('category/delete','CategoryController@delete')->name('category.delete');
Route::post('category/getdata','CategoryController@getData')->name('category.getdata');
Route::post('category/getbyname','CategoryController@getByName')->name('category.getbyname');



Route::get('product','ProductController@index')->name('product');
Route::get('product/add','ProductController@add')->name('product.add');
Route::get('product/edit','ProductController@edit')->name('product.edit');

Route::post('product/save','ProductController@save')->name('product.save');
Route::get('product/gettable','ProductController@getTable')->name('product.gettable');
Route::post('product/delete','ProductController@delete')->name('product.delete');
Route::post('product/getdata','ProductController@getData')->name('product.getdata');

