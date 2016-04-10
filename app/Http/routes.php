<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return redirect('/login');
    })->middleware('guest');

    Route::resource('products', 'ProductController');
    Route::get('/dashboard', 'ProductController@dashboard');
    Route::post('/enroll/{product}', 'ProductController@enroll');
    Route::get('/tasks', 'ProductController@tasks');
    Route::post('/moderate/{action}/{user}/{product}', 'ProductController@moderate');
    Route::get('/my_status', 'ProductController@userProductStatus');

    Route::auth();

});
