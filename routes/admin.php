<?php

use Illuminate\Support\Facades\Route;

// Redirect to dashboard
Route::get('/', function(){
    return redirect(route('admin.home'));
});

Route::name('admin.')->group(function (){

    // Reset Password
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::middleware(['admin.auth'])->group(function () {
        // Dashboard
        Route::get('dashboard', 'HomeController@index')->name('home');
        // Logout
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');
        // Users
        Route::resource('users', 'UsersController')->except([
            'create', 'store',
        ]);;
    });

    Route::middleware(['admin.guest'])->group(function () {
        // Login
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
    });

});
