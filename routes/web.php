<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Redirect;
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
    return Redirect::route('index_product');/*view('welcome');*/
});

// ini untuk apa?
Auth::routes();

// home bisa kita buang
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// selalu ingat bahwa setelah `ProductController:class`, kita menambahkan nama function yang ada di dalam 
// controller tersebut



// show product
Route::get('/product', [ProductController::class, 'index_product'])->name('index_product');

// MIDDLEWARE
// langkah 1 = membuat middleware
// langlah 2 = mengatur kernel
// langkah 3 = mengatur routing yang bisa diakses oleh admin saja
Route::middleware(['admin'])->group(function() {
    // create product
    Route::get('/product/create', [ProductController::class, 'create_product'])->name('create_product');
    Route::post('/product/create', [ProductController::class, 'store_product'])->name('store_product');

    // edit and update product
    Route::get('/product/{product}/edit', [ProductController::class, 'edit_product'])->name('edit_product');
    Route::patch('/product/{product}/edit', [ProductController::class, 'update_product'])->name('update_product');

    // delete product
    Route::delete('/product/{product}', [ProductController::class, 'delete_product'])->name('delete_product');

    // confirm payment
    Route::post('/order/{order}/confirm', [OrderController::class, 'confirm_payment'])->name('confirm_payment');

});

Route::middleware(['auth'])->group(function() {
    // show product details
    Route::get('/product/{product}', [ProductController::class, 'show_product'])->name('show_product');

    // add to cart
    Route::post('/cart/{product}', [CartController::class, 'add_to_cart'])->name('add_to_cart');

    // show cart
    Route::get('/cart', [CartController::class, 'show_cart'])->name('show_cart');

    // update cart
    Route::patch('/cart/{cart}', [CartController::class, 'update_cart'])->name('update_cart');

    // delete cart
    Route::delete('/cart/{cart}', [CartController::class, 'delete_cart'])->name('delete_cart');

    // checkout
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // show orders
    Route::get('/order', [OrderController::class, 'index_order'])->name('index_order');

    // show order detail
    Route::get('/order/{order}', [OrderController::class, 'show_order'])->name('show_order');

    // submit payment receipt
    Route::post('/order/{order}/pay', [OrderController::class, 'submit_payment_receipt'])->name('submit_payment_receipt');

    // show profile
    Route::get('/profile', [ProfileController::class, 'show_profile'])->name('show_profile');

    // edit profile
    Route::post('/profile', [ProfileController::class, 'edit_profile'])->name('edit_profile');
});