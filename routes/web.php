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

Route::get('/instagram/feed', [
    'name' => 'Instagram Feed',
    'as' => 'app.instagram.feed',
    'uses' => 'InstagramController@feed',
]);

/**
 *      Auspost Routes
 * ----------------------------------------------------------
 */

Route::get('/postcode/search', [
    'name' => 'Australia Post Postcode Search',
    'as' => 'app.postcode.search',
    'uses' => 'AustraliaPostController@index',
]);

Route::get('/postcode/api/search', [
    'name' => 'Australia Post Postcode Search',
    'as' => 'app.postcode.api.search',
    'uses' => 'AustraliaPostController@search',
]);

/**
 *      PayPal Routes
 * ----------------------------------------------------------
 */

Route::get('/paypal/{order?}', [
    'name' => 'PayPal Express Checkout',
    'as' => 'order.paypal',
    'uses' => 'PayPalController@form',
]);

Route::post('/checkout/payment/{order}/paypal', [
    'name' => 'PayPal Express Checkout',
    'as' => 'checkout.payment.paypal',
    'uses' => 'PayPalController@checkout',
]);

Route::get('/paypal/checkout/{order}/completed', [
    'name' => 'PayPal Express Checkout',
    'as' => 'paypal.checkout.completed',
    'uses' => 'PayPalController@completed',
]);

Route::get('/paypal/checkout/{order}/cancelled', [
    'name' => 'PayPal Express Checkout',
    'as' => 'paypal.checkout.cancelled',
    'uses' => 'PayPalController@cancelled',
]);

Route::post('/webhook/paypal/{order?}/{env?}', [
    'name' => 'PayPal Express IPN',
    'as' => 'webhook.paypal.ipn',
    'uses' => 'PayPalController@webhook',
]);

/**
 *      SecurePay Routes
 * ----------------------------------------------------------
 */

Route::get('/checkout/payment', [
    'name' => 'Payment',
    'as' => 'checkout.payment',
    'uses' => 'PaymentController@checkout',
]);

Route::post('/checkout/payment/{order}/process', [
    'name' => 'Payment',
    'as' => 'checkout.payment.process',
    'uses' => 'PaymentController@payment',
]);

Route::get('/checkout/payment/{order}/completed', [
    'name' => 'Payment Completed',
    'as' => 'checkout.payment.completed',
    'uses' => 'PaymentController@completed',
]);

Route::get('/checkout/payment/{order}/failed', [
    'name' => 'Payment Failed',
    'as' => 'checkout.payment.failed',
    'uses' => 'PaymentController@failed',
]);
