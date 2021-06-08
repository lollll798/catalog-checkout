<?php

use App\Events\NotificationEvent;
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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

Route::get('/getNotification', 'NotificationController@getUserNotification');
Route::get('/getUnreadNotification', 'NotificationController@getUnreadNotification');
Route::get('/sellerCancelPO', 'NotificationController@generateNotification');


// Route::get('event', function() {
//     event(new NotificationEvent('Hiiii'));
// });
// Route::get('listenEvent', function() {
//     return view('listenBroadcast');
// });

