<?php

use Illuminate\Routing\Router;


Route::group(['middleware' => ['guest:admin']], function (Router $router) {
    Auth::routes(['register' => false, 'reset' => false]);
});

Route::group(['middleware' => ['auth:admin']], function (Router $router) {

    $router->post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    $router->get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('dashboard');
    
    $router->resource('product', ProductController::class);
   

});
