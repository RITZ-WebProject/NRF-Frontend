<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\InfoController;

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
Route::post('/dinger-callback', [OrderController::class, 'dingerCallback']);
Route::get('/success', [OrderController::class, 'success'])->name('success');
Route::get('/error', [OrderController::class, 'error'])->name('error');

Route::middleware(['active.check'])->group(function() {Route::get('/', function () {return view('layouts.home');});

Route::get('/shop',[ShopController::class,'index'])->name('shop');
Route::get('/category/{category}', [ShopController::class, 'showByCategory'])->name('category');
Route::get('/payment_success',[OrderController::class, 'checkPayment']);
Route::middleware(['logout'])->group(function() {

});

Route::get('/login',[LoginController::class,'index']);
Route::post('/authenticate', [LoginController::class,'customLogin'])->name('authenticate');
Route::get('/signout',[LoginController::class,'signOut']);

Route::get('/register', [CustomersController::class,'create']);
Route::post('/customer/store',[CustomersController::class,'store'])->name('customer.store');
Route::post('newsletter-signup',[CustomersController::class,'newsletter_signup'])->name('newsletter');

Route::middleware(['logout'])->group(function() {
	Route::middleware(['cart.clear'])->group(function() {
    	Route::get('/add-to-cart/{id}/{size}',[OrderController::class,'addToCart'])->name('add-to-cart');
    	Route::get('/cart',[OrderController::class,'cart']);
    	Route::post('update-cart', [OrderController::class, 'cart_update'])->name('update_cart');
    	Route::get('/remove-from-cart/{id}', [OrderController::class, 'removeCart'])->name('cart.remove');
    	Route::get('/clearCart', [OrderController::class, 'clearCart'])->name('cart.clear');
		Route::post('/check-stock', [OrderController::class, 'checkStock'])->name('check-stock');
		
    	Route::get('/account',[CustomersController::class,'profile']);
		Route::get('/account/{id}',[CustomersController::class,'editProfile']);
        Route::put('/storeProfile/{id}',[CustomersController::class,'storeProfile'])->name('storeProfile');
        Route::post('/update-profile', [CustomersController::class, 'updateProfile'])->name('update-profile');
		Route::get('/address',[CustomersController::class,'editAddress']);
		Route::put('storeAddress',[CustomersController::class,'storeAddress'])->name('storeAddress');
    	Route::get('/invoice/{id}',[CustomersController::class,'invoice']);
    	Route::get('/order_details/{id}',[CustomersController::class,'order_view']);
    	Route::get('/checkout',[OrderController::class,'cartCheckout'])->middleware('checkCart');
    	Route::post('/checkout',[OrderController::class,'orderStore'])->name('order.store');
    });
    
});

Route::post('/contact-us', [ContactUsController::class, 'submitForm'])->name('contact-us.submit');
Route::get('/contact',function () {return view('contact.contact-us');});

// Job
Route::get('/career',[InfoController::class,'showDates'])->name('info.career');

// Gallery
Route::get('/gallery',[InfoController::class,'gallery'])->name('info.gallery');

// Info
Route::get('/about',function () {return view('info.about');});
Route::get('/press',function () {return view('info.press');});
Route::get('/payment',function () {return view('info.payment');});
Route::get('/faq', function() {return view('info.faq');});
Route::get('/terms-conditions', function() {return view('info.terms-conditions');});
Route::get('/refund-policy',function () {return view('info.refund-policy');});

Route::get('/product-details/{id}',[ProductController::class,'detail']);
Route::get('/product-detail',function() {return view('products.product-details');});


//get District and Township
Route::get('getDistrict',[OrderController::class, 'getDistrict'])->name('getDistrict');
Route::get('getTownship',[OrderController::class, 'getTownship'])->name('getTownship');
Route::post('/validateAddress',[OrderController::class, 'validateAddress']);

});

