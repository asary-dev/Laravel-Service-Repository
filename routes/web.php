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


Auth::routes();

// for listing of all items
Route::get('/', 'HomeController@index')->name('home');
// for product detail and purchase page
Route::get('/product/{id}', 'HomeController@product')->name('product.detail');
Route::post('/product/{id}', 'HomeController@purchase')->name('product.purchase');
// for after purchase details
Route::get('/order/{id}', 'HomeController@order')->name('order');

Route::group(['prefix'=>'admin','as'=>'admin.',"middleware"=>"auth"], function(){
    Route::get('/', 'HomeController@admin')->name("home");
    Route::get('order/select_products', 'OrderController@selectProduct');
    Route::resources([
        "user"=>"UserController",
        "product"=>"ProductController",
        "order"=>"OrderController",
    ]);
    
});
