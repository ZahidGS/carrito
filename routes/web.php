<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeWebHookController;

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

Auth::routes();

Route::get('/home', [ProductController::class, 'index'])->name('home');

Route::post('stripe/webhook', [StripeWebHookController::class, 'handleWebhook']);


Route::get('/add-product-to-cart/{product}', [ProductController::class,'addProductToCart'])->name('add_product_to_cart');
Route::get('/cart', [ProductController::class,'showCart'])->name('cart');
Route::get('/remove-product-from-cart/{product}', [ProductController::class,'removeProductFromCart'])->name('remove_product_from_cart');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout_form');
    Route::post('/checkout', [CheckoutController::class, 'processOrder'])
    ->name('process_checkout');


    Route::get("credit-card", [BillingController::class,'creditCardForm'])
    ->name("billing.credit_card_form");
    Route::post("credit-card", [BillingController::class,'processCreditCardForm'])
    ->name("billing.process_credit_card");

    Route::get('/products', [ProductController::class, 'products'])
    ->name('products');
    Route::get('/orders', [ProductController::class, 'orders'])
    ->name('products.orders');

});
