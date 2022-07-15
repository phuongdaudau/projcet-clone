<?php
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
});