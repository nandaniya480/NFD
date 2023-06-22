<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\auth\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login-verify', [AuthController::class, 'loginVerify'])->name('login.verify');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('forgot-password', [ForgotPasswordController::class, 'forgotPassword'])->name('forgot-password');
Route::post('forgot-password-verify', [ForgotPasswordController::class, 'verifyEmail'])->name('verifyEmail');
Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('update-password');

Route::middleware(['auth:web', 'verified'])->group(function ($route) {
    $route->group(['namespace' => 'App\Http\Controllers\admin'], function ($adminRoute) {
        $adminRoute->get('dashboard', 'DashboardController@home')->name('dashboard');

        $adminRoute->post('product.bulk-action', 'ProductController@bulkAction')->name('product.bulk-action');

        $adminRoute->resource('roles', RoleController::class);
        $adminRoute->resource('users', UserController::class);
        $adminRoute->resource('product', ProductController::class);
    });
});
