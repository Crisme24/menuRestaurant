<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('register', 'UserController@register');
        Route::post('login', 'UserController@login');

        Route::middleware('auth:api')->group(function() {
            Route::get('info','UserController@getUserInfo');
            Route::get('logout', 'UserController@logout');
            Route::put('', 'UserController@update');
        });
    });
    Route::group([
        'prefix'=>'categories',
    ],function(){
        Route::get('','CategoryController@getAll');
        Route::get('{id}','CategoryController@getOne');
        Route::get('/search/{search}', 'CategoryController@searchCategory');
       Route::middleware(['auth:api','checkRole:admin|superAdmin|isAdmin'])->group(function(){
        Route::post('','CategoryController@insert');
        Route::put('{id}','CategoryController@update');
        Route::delete('{id}','CategoryController@delete');
       });
    });
    Route::group([
        'prefix' => 'products'
    ], function () {
        Route::get('','ProductController@getAll');
        Route::get('{id}','ProductController@getOne');
        Route::get('/search/{search}', 'ProductController@searchProduct');
        Route::middleware(['auth:api','checkRole:admin|superAdmin|isAdmin'])->group(function(){
            Route::get('restore/{id}','ProductController@restore');
            Route::post('', 'ProductController@insert');
            Route::post('/image/{id}','ProductController@uploadImage');
            Route::put('{id}', 'ProductController@update');
            Route::delete('{id}', 'ProductController@delete');
        });
    });

});
