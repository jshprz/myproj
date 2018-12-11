<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
if (App::environment('production')) {
     URL::forceScheme('http');
}
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('products-tobe-displayed','ShopController@getProductsToBeDisplayed');
Route::post('product-category-tobe-displayed','ShopController@getProductCategoryTobeDisplayed');
Route::post('get-similar-product','ProductController@getSimilarProduct');
Route::post('search-by-price-range','ProductController@searchByPriceRange');
Route::post('save-payment','ShopController@savePayment');
Route::post('get-payment','ShopController@getPayment');
Route::get('get-last-transaction','TransactionController@lastTransaction');
Route::post('search-by-slider','ProductController@searchBySlider');