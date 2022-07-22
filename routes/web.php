<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['guest']], function () {
    Auth::routes(['logout' => false]);
});


Route::get('/', [App\Http\Controllers\Member\ProductController::class, 'list'])->name('product.list');
Route::get('products/search', [App\Http\Controllers\Member\ProductController::class, 'search'])->name('product.search');
Route::get('product/{slug}', [App\Http\Controllers\Member\ProductController::class, 'detail'])->name('product.detail');
Route::get('cart', [App\Http\Controllers\Member\CartController::class, 'list'])->name('cart.list');
Route::get('saveQtyItemCart/{id}/{quantity}', [App\Http\Controllers\Member\CartController::class, 'saveQtyItemCart']);
Route::get('deleteListCart/{id}', [App\Http\Controllers\Member\CartController::class, 'deleteListCart']);

Route::post('/add-cart-ajax',[App\Http\Controllers\Member\CartController::class, 'saveCartAjax'])->name('cart_ajax');
Route::get('/show-cart-ajax',[App\Http\Controllers\Member\CartController::class, 'showCartAjax'])->name('show_cart_ajax');
Route::post('/update-cart-ajax',[App\Http\Controllers\Member\CartController::class, 'updateCartAjax'])->name('update_cart_ajax');
Route::post('/delete-cart-ajax',[App\Http\Controllers\Member\CartController::class, 'deleteCartAjax'])->name('delete_cart_ajax');
Route::get('/update-car-user',[App\Http\Controllers\Member\CartController::class, 'updateCartUser'])->name('update_cart_user');
Route::get('/delete-all',[App\Http\Controllers\Member\CartController::class, 'deleteAllCart'])->name('delete_all_cart');


require __DIR__.'/auth.php';