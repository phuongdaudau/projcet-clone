<?php

use Illuminate\Routing\Router;


Route::group(['middleware' => ['guest:admin']], function (Router $router) {
    Auth::routes(['register' => false, 'reset' => false]);
    $router->get('reset-password', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('reset_password');
    $router->post('reset-password', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'requestPassword'])->name('request_password');
    $router->get('reset/{token}', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'resetPassword'])->name('reset_password_admin');
    $router->post('reset', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'resetPasswordAdmin'])->name('reset');
});

Route::group(['middleware' => ['auth:admin']], function (Router $router) {

    $router->post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    $router->get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('dashboard');
    
    $router->resource('product', ProductController::class);

    $router->post('multidelete', [App\Http\Controllers\Admin\ProductController::class, 'multidelete']);
});
