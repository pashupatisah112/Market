<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware'=>['auth:api'],'namespace'=>'Admin'],function(){
    Route::resource('categories', 'CategoryController');
    Route::resource('subcategories', 'SubController');
    Route::resource('size', 'SizeController');
    Route::resource('color', 'ColorController');
    Route::resource('company', 'CompanyController');
    Route::resource('types', 'TypeController');
    Route::resource('tags', 'TagController');


    Route::get('customers','CustomerController@getCustomers');

    //products
    Route::post('getProductTags','ProductController@getProductTags');
    Route::get('getProductSup','ProductController@productSup');
    Route::get('products','ProductController@getProducts');
    Route::post('products','ProductController@store');
    Route::delete('products/{product}','ProductController@delete');
    Route::put('products/{product}','ProductController@update');
    Route::post('imageUpload','ProductController@imageUpload');
    Route::post('addPrimaryImage','ProductController@addPrimaryImage');
    Route::post('updateImage','ProductController@updateImage');

    //featured
    Route::get('featured','FeaturedController@index');
    Route::get('getProductsFeatured','FeaturedController@getProductsFeatured');
    Route::post('featured','FeaturedController@store');
    Route::delete('featured/{featured}','FeaturedController@delete');
    Route::put('featured/{featured}','FeaturedController@update');
    Route::post('addFeaturedImage','FeaturedController@addFeaturedImage');

    //Comments
    Route::get('commentList','CommentController@commentList');
    Route::post('replyComment','CommentController@replyComment');
    Route::post('deleteComment','CommentController@delete');

    //sales
    Route::get('sales','SalesController@index');
    Route::post('changeDeliveryStatus','SalesController@changeDeliveryStatus');

    //analytics
    Route::get('getDailyData','AnalyticsController@getDailyData');

});

Route::group(['middleware'=>['auth:api'],'namespace'=>'User'],function(){
    //wishlist
    Route::post('addToWishlist','WishlistController@addToWishlist');
    Route::post('removeFromWishlist','WishlistController@removeFromWishlist');
    Route::get('getWishlist','WishlistController@getWishlist');
    Route::get('getWishlistItem','WishlistController@getWishListItem');
    Route::post('addToCart','CartController@addToCart');

    //cart
    Route::get('getCart','CartController@getCart');
    Route::get('getCartDetail','CartController@getCartDetail');
    Route::get('getCartListItem','CartController@getCartListItem');
    Route::post('removeFromCartlist','CartController@removeFromCartlist');

    //quickview
    Route::post('getQuickViewItem','ProductController@getQuickViewItem');

    //rating
    Route::post('getRatings','ProductController@getRatings');
    Route::post('giveRating','ProductController@giveRating');

    //comments
    Route::post('getComments','ProductController@getComments');
    Route::post('makeComment','ProductController@makeComment');

    //tags
    Route::post('getTags','ProductController@getTags');

    //similar
    Route::post('getSimilarProducts','ProductController@getSimilarProducts');

    //collections
    Route::get('getCollection','ProductController@getCollection');

    //offers
    Route::get('getOffers','ProductController@getOffers');

    //payments
    Route::post('verifyKhaltiPayment','PaymentController@verifyKhaltiPayment');
});
//Featured
Route::get('getFeatured','User\ProductController@getFeatured');
Route::post('getSimilarFeatured','User\ProductController@getSimilarFeatured');

//Top Selling
Route::get('getTopProducts','User\ProductController@getTopProducts');
Route::get('getTopCategory','User\ProductController@getTopCategory');
Route::post('filterTopCategories','User\ProductController@filterTopCategories');

//Offered
Route::get('getProductOffers','User\ProductController@getProductOffers');

Route::get('getCategories','User\ProductController@getCategories');
Route::get('latestProducts','User\ProductController@getLatestProducts');
Route::post('getProducts','User\ProductController@getProducts');
Route::post('getSelectedCategory','User\ProductController@getSelectedCategory');

//Filter
Route::post('getFilters','User\FilterController@getFilters');
Route::post('sortBy','User\FilterController@sortBy');
Route::post('colorFilter','User\FilterController@colorFilter');
Route::post('companyFilter','User\FilterController@companyFilter');
Route::post('priceFilter','User\FilterController@priceFilter');

Route::post('getProductDetails','User\ProductController@getProductDetails');


//Auth
Route::post('register', 'AuthController@register');
Route::post('customer-login', 'AuthController@customerLogin');
Route::post('admin-login', 'AuthController@adminLogin');
Route::get('verify', 'AuthController@verify');


Route::group(['middleware' => ['web']], function () {
    //facebook
Route::get('facebook/auth/redirect', 'AuthController@handleFacebookRedirect');
Route::get('facebook/auth/callback', 'AuthController@handleFacebookCallback');

//google
Route::get('google/auth/redirect', 'AuthController@handleGoogleRedirect');
Route::get('google/auth/callback', 'AuthController@handleGoogleCallback');


});