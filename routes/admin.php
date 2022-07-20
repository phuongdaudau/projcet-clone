<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['guest:admin']], function (Router $router) {
    Auth::routes(['register' => false, 'reset' => false]);
});

Route::group(['middleware' => 'auth:admin'], function (Router $router) {
    Route::post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('dashboard');
    Route::resource('product', ProductController::class);
    Route::post('multidelete', [App\Http\Controllers\Admin\ProductController::class, 'multidelete']);
});