<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['guest:admin']], function (Router $router) {
    Auth::routes(['register' => false, 'reset' => false]);
    Route::get('reset-password', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('reset_password');
    Route::post('reset-password', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'requestPassword'])->name('request_password');
    Route::get('reset/{token}', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'resetPassword'])->name('reset_password_admin');
    Route::post('reset', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'resetPasswordAdmin'])->name('reset');
});

Route::group(['middleware' => ['auth:admin']], function (Router $router) {

    Route::post('/logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('dashboard');
    
    Route::resource('product', ProductController::class);

});

use App\Http\Controllers\Admin\Auth\MailChimpController;

Route::get('/send-mail-using-mailchimp', [MailChimpController::class, 'index'])->name('send.mail.using.mailchimp.index');
