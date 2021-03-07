<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/unsubscribe', 'UnsubscribesController@index'); //退会

Route::get('/', function () {
  return view('welcome');
})->name('top');;   


// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
});
Route::get('guest', 'Auth\LoginController@authenticate')->name('login.guest');

// ユーザ機能
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show', 'destroy', 'update', 'edit']]);
    Route::delete('cycledestroys/{id}', 'CycledestroysController@destroy')->name('cycledestroys.destroy');
    Route::resource('cycles', 'CyclesController');
    Route::resource('post_searches', 'Post_SearchesController', ['only' => ['index']]);
    Route::get('city_searches', 'Area_SearchesController@index');
    Route::resource('unsubscribe', 'UnsubscribesController', ['only' => ['index']]);
    Route::resource('cyclecomments', 'CyclecommentsController', ['only' => ['destroy']]);
    Route::post('cyclecomments/{id}/ajax', 'CyclecommentsController@ajax');
    Route::get('ajax/{id}', 'CyclecommentsController@ajaxindex');
    Route::post('ajax', 'CyclecommentsController@ajaxstore');
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('favorites', 'UsersController@favorites')->name('users.favorites');
        });
    Route::group(['prefix' => 'cycles/{id}'], function () {
        Route::post('/favorite', 'FavoritesController@store')->name('cycles.favorite');
        Route::delete('/unfavorite', 'FavoritesController@destroy')->name('cycles.unfavorite');
        });
});

//　googlemap
Route::get('cyclemaps', 'CyclemapsController@index')->name('cyclemaps.index');
