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
    //category
    Route::post('getCategories', 'GetController@getCategories');
    Route::post('addCategory','CategoryController@addCategory');
    Route::put('updateCategory/{category}','CategoryController@updateCategory');
    Route::delete('deleteCategory/{category}','CategoryController@deleteCategory');

    Route::post('getColors', 'GetController@getColors');
    Route::post('getSubCategories', 'GetController@getSubCategories');
    Route::post('getSizes', 'GetController@getSizes');
    Route::post('getCompanies', 'GetController@getCompanies');
    Route::post('getTypes', 'GetController@getTypes');
    Route::post('getAllTags', 'GetController@getTags');

    Route::resource('subcategories', 'SubController');
    Route::resource('size', 'SizeController');
    Route::resource('color', 'ColorController');
    Route::resource('company', 'CompanyController');
    Route::resource('types', 'TypeController');
    Route::resource('tags', 'TagController');


    Route::post('customers','CustomerController@getCustomers');

    //products
    Route::post('getProductTags','ProductController@getProductTags');
    Route::get('getProductSup','ProductController@productSup');
    Route::post('myProducts','ProductController@myProducts');
    Route::post('products','ProductController@store');
    Route::delete('products/{product}','ProductController@delete');
    Route::put('products/{product}','ProductController@update');
    Route::post('imageUpload','ProductController@imageUpload');
    Route::post('addPrimaryImage','ProductController@addPrimaryImage');
    Route::post('updateImage','ProductController@updateImage');
    Route::post('getSecondaryImages','ProductController@getSecondaryImages');
    Route::post('changeProductStatus','ProductController@changeProductStatus');
    Route::post('deleteSecImage','ProductController@deleteSecImage');

    //featured
    Route::post('getFeatured','FeaturedController@index');
    Route::get('getProductsFeatured','FeaturedController@getProductsFeatured');
    Route::post('featured','FeaturedController@store');
    Route::delete('featured/{featured}','FeaturedController@delete');
    Route::put('featured/{featured}','FeaturedController@update');
    Route::post('addFeaturedImage','FeaturedController@addFeaturedImage');

    //Comments
    Route::post('commentList','CommentController@commentList');
    Route::post('replyComment','CommentController@replyComment');
    Route::post('deleteComment','CommentController@delete');

    //orders
    Route::post('getOrders','OrderController@getOrders');
    Route::post('getOrderDetail','OrderController@getOrderDetail');
    Route::post('changeDeliveryStatus','OrderController@changeDeliveryStatus');
    Route::post('deleteOrder','OrderController@deleteOrder');

    //analytics
    Route::get('getDailyData','AnalyticsController@getDailyData');
    Route::get('getDisplayData','AnalyticsController@getDisplayData');

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

    

    //rating
    Route::post('giveRating','ProductController@giveRating');

   //comments
   Route::post('makeComment','ProductController@makeComment');
    
    //payments
    Route::post('verifyKhaltiPayment','PaymentController@verifyKhaltiPayment');

    //history
    Route::post('getPurchaseHistory','ProductController@getPurchaseHistory');

    //search
    Route::post('getSearch','ProductController@getSearch');

    //order
    Route::post('makeOrder','ProductController@makeOrder');

});
 //comments
 Route::post('getComments','User\ProductController@getComments');


//tags
Route::post('getTags','User\ProductController@getTags');

//similar
Route::post('getSimilarProducts','User\ProductController@getSimilarProducts');

//rating
Route::post('getRatings','User\ProductController@getRatings');

//Featured
Route::get('getFeatured','User\ProductController@getFeatured');
Route::post('getSimilarFeatured','User\ProductController@getSimilarFeatured');

//collections
Route::get('getCollection','User\ProductController@getCollection');

//Top Selling
Route::get('getTopProducts','User\ProductController@getTopProducts');
Route::get('getTopCategory','User\ProductController@getTopCategory');
Route::post('filterTopCategories','User\ProductController@filterTopCategories');
Route::post('getTopSellers','User\ProductController@getTopSellers');
Route::post('fromTopBrands','User\ProductController@fromTopBrands');

//Offered
Route::get('getProductOffers','User\ProductController@getProductOffers');
Route::post('getOffers','User\ProductController@getOffers');

//sale
Route::get('getSale','User\ProductController@getSale');


//general
Route::get('getCategories','User\ProductController@getCategories');
Route::get('latestProducts','User\ProductController@getLatestProducts');
Route::post('getProducts','User\ProductController@getProducts');
Route::post('getSelectedCategory','User\ProductController@getSelectedCategory');

//quickview
Route::post('getQuickViewItem','User\ProductController@getQuickViewItem');

//Filter
Route::post('getFilters','User\FilterController@getFilters');
Route::post('sortBy','User\FilterController@sortBy');
Route::post('colorFilter','User\FilterController@colorFilter');
Route::post('companyFilter','User\FilterController@companyFilter');
Route::post('priceFilter','User\FilterController@priceFilter');

Route::post('getProductDetails','User\ProductController@getProductDetails');


//Auth
Route::post('register', 'AuthController@register');
Route::post('socialLogin', 'AuthController@socialLogin');
Route::post('sendConfirmEmail', 'AuthController@sendConfirmEmail');
Route::post('sendPasswordResetCode', 'AuthController@sendPasswordResetCode');
Route::post('resetPassword', 'AuthController@resetPassword');
Route::post('customer-login', 'AuthController@customerLogin');
Route::post('admin-login', 'AuthController@adminLogin');
Route::get('verify', 'AuthController@verify');

?>