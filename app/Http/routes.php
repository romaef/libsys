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

Route::get('/', function () {
	if(Auth::check()) {
        if(Auth::user()->userType == 'admin'){
            return redirect()->intended('/books');
        }else{
            return redirect()->intended('/books/search');
        }

    } else {
  		return redirect('auth/login');
    }
});

// Authentication Routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Registration Routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Books Routes...
Route::get('/books', 'BookController@index');
Route::post('/book', 'BookController@store');
Route::delete('/book/{book}', 'BookController@destroy');
Route::get('/book/edit/{book}', 'BookController@edit');
Route::post('/book/update/{book}', 'BookController@updateBook');

// Users Routes...
Route::get('/users', 'UserController@index');
Route::post('/user', 'UserController@store');
Route::delete('/user/{user}', 'UserController@destroy');
Route::get('/user/edit/{user}', 'UserController@edit');
Route::post('/user/update/{user}', 'UserController@updateUser');

// Borrow Routes...
Route::get('/books/search', 'BookController@search');
Route::post('/book/borrow/{book}', 'BookController@borrowBook');

// Return Routes...
Route::get('/books/bookReturn', 'BookController@bookReturnList');
Route::post('/book/bookReturn/{bookTransaction}', 'BookController@returnBook');

// Report Routes...
Route::get('/reports', 'BookController@reports');



