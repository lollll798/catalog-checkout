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

Route::get('/', 'APIController@requestCatalogList');

Route::get('/catalog', 'HomeController@index')->name('home');
Route::get('/getAllRaw', 'APIController@getAllRawData');
Route::get('/getAllFormated', 'APIController@getAllFormatedData');
Route::get('/requestCatelogList', 'APIController@requestCatalogList');
Route::get('/requestProductDetail', 'APIController@requestProductDetail');

Route::post('/addToCart', 'CartController@addToCart');
Route::get('/getCartItems', 'CartController@getCartDetails');
Route::post('/checkout', 'CartController@checkoutCart');

Route::get('/getOrderPurcahse', 'OrderPurchaseController@getOrderPurchase');
Route::get('/getOrderPurcahseDetails', 'OrderPurchaseController@getOrderPurchaseDetails');
Route::post('/cancelOrder', 'OrderPurchaseController@orderPurchaseAction');
