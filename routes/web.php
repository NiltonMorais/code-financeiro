<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/user', function () {
    \Illuminate\Support\Facades\Auth::LoginUsingId(2);
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', function(){
    return redirect()->route('admin.home');
});

Route::get('/app', function(){
    return view('layouts.spa');
});

Route::group(['prefix'=>'admin', 'as'=>'admin.'],function(){
    Auth::routes();
    Route::group(['middleware'=>'can:access-admin'],function(){
        Route::get('/home', 'HomeController@index')->name('home');
    });
});
