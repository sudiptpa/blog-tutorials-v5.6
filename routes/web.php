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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trending', [
    'name' => 'Trending',
    'as' => 'app.trending',
    'uses' => 'TrendingController@show',
]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('blog/rss', [
    'as' => 'app.blog.rss',
    'uses' => 'BlogController@rss',
]);

Route::get('blog/{slug}', [
    'as' => 'app.blog.view',
    'uses' => 'BlogController@view',
]);
