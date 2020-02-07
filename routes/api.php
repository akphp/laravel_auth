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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'User\AuthController@login_user');
    Route::post('register', 'User\AuthController@register');
    // ------------------------------------------------------
       // auth:gurard   gurard = admin , users , ..............
    Route::group(['middleware' => 'auth:api'], function()
    {
        Route::post('profile-user', 'User\AuthController@profile');
    });
   

    Route::post('admin/login', 'Admin\AuthController@login_admin');
    Route::post('admin/register', 'Admin\AuthController@register');
     // auth:gurard   gurard = admin , users , ..............
    Route::group(['middleware' => 'auth:admin'], function()
    {
        Route::post('profile-admin', 'Admin\AuthController@profile');
    });
});
