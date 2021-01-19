<?php

use App\Http\Controllers\Admin\ProductController;
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

    Route::get('getProductSup','ProductController@productSup');
    Route::get('products','ProductController@getProducts');
    Route::post('products','ProductController@store');
    Route::delete('products/{product}','ProductController@delete');
    Route::post('imageUpload','ProductController@imageUpload');

});
Route::get('getCategories','User\ProductController@getCategories');
Route::get('latestProducts','User\ProductController@getLatestProducts');



//Auth
Route::post('register', 'AuthController@register');
Route::post('customer-login', 'AuthController@customerLogin');
Route::post('admin-login', 'AuthController@adminLogin');
Route::get('verify', 'AuthController@verify');
