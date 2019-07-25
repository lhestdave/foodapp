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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/order/savemenu', 'OrderController@savemenu');
Route::get('/foodcart', 'OrderController@viewfoodcart');
Route::post('/order/delItem', 'OrderController@delItem');
Route::post('/coupon/get', 'OrderController@getCoupon');
Route::post('/saveorder', 'OrderController@saveOrder');

Route::get('/orders','OrderController@viewOrders');
Route::get('/order/{id}','OrderController@viewOrderItems');
