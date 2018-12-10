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
Route::post('products-tobe-displayed','buyer\ShopController@getProductsToBeDisplayed');
Route::post('product-category-tobe-displayed','buyer\ShopController@getProductCategoryTobeDisplayed');
Route::post('get-similar-product','buyer\ProductController@getSimilarProduct');
Route::post('search-by-price-range','buyer\ProductController@searchByPriceRange');
Route::post('save-payment','buyer\ShopController@savePayment');
Route::post('get-payment','buyer\ShopController@getPayment');
Route::get('get-last-transaction','buyer\TransactionController@lastTransaction');
Route::post('search-by-slider','buyer\ProductController@searchBySlider');