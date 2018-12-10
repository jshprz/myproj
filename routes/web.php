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
Route::get('/loginss','Auth\LoginController@dummy')->name('login');  
Route::get('/activate/{storeName}/{token}','Auth\RegistrationController@activate')->name('registerBuyerActivate');
Route::group(['middleware' => 'guest', 'as' => 'guest.'], function(){
    
    Route::post('/register-buyer','Auth\RegistrationController@registerBuyer')->name('postBuyerRegister');
    Route::post('/login-buyer','Auth\LoginController@Login')->name('loginBuyer');
    Route::get('/{storeName}/product-details','ProductController@details')->name('details');
    Route::get('/{storeName}/user-login','auth\LoginController@index')->name('user-login');
    Route::get('/{storeName}/user-registration','auth\RegistrationController@index')->name('user-register');
});

Route::group(['middleware' => 'auth','as' => 'auth.'], function(){
    Route::get('/{storeName}/buyer-logout','Auth\LoginController@Logout')->name('buyerLogout');
    Route::get('/{storeName}','ShopController@index')->name('shops');
    Route::get('/{storeName}/cart','ShopController@viewCart')->name('viewcart');
    Route::post('/{storeName}/checkout','PaymentController@index')->name('checkout');


    Route::post('/api/view-cart','ShopController@cartDataPost');
    Route::get('/api/view-cart-get','ShopController@cartDataGet');
    Route::post('add-to-cart','ShopController@addToCart')->name('addcart');
    Route::post('/api/remove-item-cart','ShopController@removeItemFromCart');
    Route::get('/api/get-authenticated-store','ShopController@getAuthenticatedStore');
    Route::get('/{storeName}/statuswithpaypal','PaymentController@getPaypalPaymentStatus')->name('paywithpaypalstatus');
    Route::post('/{storeName}/paywithpaypal','PaymentController@payWithPaypal')->name('paywithpaypal');
    Route::post('/{storeName}/paywithstripe','PaymentController@paywithstripe')->name('paywithstripe');
    Route::get('/{storeName}/track-delivery','PaymentController@trackDelivery')->name('trackDelivery');
    Route::get('/{storeName}/select-courier-service','PaymentController@selectCourier')->name('selectCourier');
    Route::get('/{storeName}/create-delivery','PaymentController@createDelivery')->name('createDelivery');
    Route::get('/{storeName}/my-transactions','TransactionController@index')->name('mytransaction');
    Route::get('/api/get-transactions','TransactionController@getTransactions')->name('getTransactions');
    Route::post('/api/post-transactions','TransactionController@getTransactionsById')->name('getTransactionsById');
    Route::post('/api/create-feedback','ShopController@createFeedback')->name('createFeedback');
    Route::post('/api/create-star','ShopController@createStar')->name('createStar');
    Route::post('/api/generate-qrcode','UserController@genQrCode');
});