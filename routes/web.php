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


Route::get('/loginss','Auth\LoginController@dummy')->name('login');  
Route::get('/activate/{token}','Auth\RegistrationController@activate')->name('registerBuyerActivate');
Route::group(['middleware' => 'guest', 'as' => 'guest.'], function(){
    Route::get('/hello','Auth\LoginController@index')->name('loginlogin');
    Route::post('/register-buyer','Auth\RegistrationController@registerBuyer')->name('postBuyerRegister');
    Route::post('/login-buyer','Auth\LoginController@Login')->name('loginBuyer');
    Route::get('/product-details','ProductController@details')->name('details');
    Route::get('/user-login','Auth\LoginController@index')->name('user-login');
    Route::get('/user-registration','Auth\RegisterController@index')->name('user-register');
});

Route::group(['middleware' => 'auth','as' => 'auth.'], function(){
    Route::get('/buyer-logout','Auth\LoginController@Logout')->name('buyerLogout');
    Route::get('/','ShopController@index')->name('shops');
    Route::get('/cart','ShopController@viewCart')->name('viewcart');
    Route::post('/checkout','PaymentController@index')->name('checkout');


    Route::post('/api/view-cart','ShopController@cartDataPost');
    Route::get('/api/view-cart-get','ShopController@cartDataGet');
    Route::post('add-to-cart','ShopController@addToCart')->name('addcart');
    Route::post('/api/remove-item-cart','ShopController@removeItemFromCart');
    Route::get('/api/get-authenticated-store','ShopController@getAuthenticatedStore');
    Route::get('/statuswithpaypal','PaymentController@getPaypalPaymentStatus')->name('paywithpaypalstatus');
    Route::post('/paywithpaypal','PaymentController@payWithPaypal')->name('paywithpaypal');
    Route::post('/paywithstripe','PaymentController@paywithstripe')->name('paywithstripe');
    Route::get('/track-delivery','PaymentController@trackDelivery')->name('trackDelivery');
    Route::get('/select-courier-service','PaymentController@selectCourier')->name('selectCourier');
    Route::get('/create-delivery','PaymentController@createDelivery')->name('createDelivery');
    Route::get('/my-transactions','TransactionController@index')->name('mytransaction');
    Route::get('/api/get-transactions','TransactionController@getTransactions')->name('getTransactions');
    Route::post('/api/post-transactions','TransactionController@getTransactionsById')->name('getTransactionsById');
    Route::post('/api/create-feedback','ShopController@createFeedback')->name('createFeedback');
    Route::post('/api/create-star','ShopController@createStar')->name('createStar');
    Route::post('/api/generate-qrcode','UserController@genQrCode');
});