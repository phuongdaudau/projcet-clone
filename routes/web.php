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

Route::get('/', [App\Http\Controllers\Member\ProductController::class, 'list'])->name('product.list');
Route::get('products/search', [App\Http\Controllers\Member\ProductController::class, 'search'])->name('product.search');
Route::get('product/{slug}', [App\Http\Controllers\Member\ProductController::class, 'detail'])->name('product.detail');
Route::get('cart', [App\Http\Controllers\Member\CartController::class, 'list'])->name('cart.list');
Route::get('saveQtyItemCart/{id}/{quantity}', [App\Http\Controllers\Member\CartController::class, 'saveQtyItemCart']);
Route::get('deleteListCart/{id}', [App\Http\Controllers\Member\CartController::class, 'deleteListCart']);


Route::group(['as' => 'member.', 'prefix' => 'member'], function () {
    
});

// Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
//     Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
// });

require __DIR__.'/auth.php';