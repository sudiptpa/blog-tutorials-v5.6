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

/**
 *      Instagram Routes
 * ----------------------------------------------------------
 */

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

/**
 *      NAB UnionPay Tranasct Routes
 * ----------------------------------------------------------
 */

Route::get('/checkout/payment/unionpay', [
    'name' => 'UnionPay Checkout Payment',
    'as' => 'checkout.payment.unionpay',
    'uses' => 'UnionPayController@checkout',
]);

Route::post('/checkout/payment/{order}/unionpay/process', [
    'name' => 'UnionPay Checkout Payment',
    'as' => 'checkout.payment.unionpay.process',
    'uses' => 'UnionPayController@payment',
]);

Route::get('/checkout/payment/{order}/unionpay/completed', [
    'name' => 'UnionPay Payment Completed',
    'as' => 'checkout.payment.unionpay.completed',
    'uses' => 'UnionPayController@completed',
]);

Route::get('/checkout/payment/{order}/failed', [
    'name' => 'UnionPay Payment Failed',
    'as' => 'checkout.payment.unionpay.failed',
    'uses' => 'UnionPayController@failed',
]);

http://localhost/laravelv5.6/public/checkout/payment/34/unionpay/completed?settdate=20190221&expirydate=&callback_status_code=&restext=Approved&fingerprint=4474d78bd7fe08a67bb462873b110ab2b5d12001&merchant=XYZ0010&refid=ORDERNO34&pan=625094...014&summarycode=1&rescode=00&txnid=186001&timestamp=20190221051258
