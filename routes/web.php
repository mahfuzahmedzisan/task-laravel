<?php

use App\Http\Controllers\Admin\AdminManagement\ProductController as AdminProductController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\Admin\AdminManagement\CategoryController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomeController as UserLoginController;
use App\Http\Controllers\User\CustomerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('customer.products.index');
});

Auth::routes();

Route::get('/home', [UserLoginController::class, 'index'])->name('home');

// Admin Routes
Route::controller(AdminLoginController::class)->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', 'showLoginForm')->name('login'); // Admin Login Form
    Route::post('/login', 'login')->name('login.submit'); // Admin Login Submit (Handled by AuthenticatesUsers)
    Route::post('/logout', 'logout')->name('logout'); // Admin Logout
});

// Admin Dashboard Routes (Requires Admin Authentication)

Route::group(['middleware' => 'auth:admin', 'prefix' => 'admin'], routes: function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::group(['as' => 'pm.', 'prefix' => 'products'], routes: function () {
        Route::resource('product', AdminProductController::class);
    });

    Route::group(['as' => 'c.'], routes: function () {
        Route::resource('category', CategoryController::class);
    });
});

Route::group(['as' => 'customer.'], routes: function () {
    Route::get('cart', [CustomerController::class, 'viewCart'])->name('cart.view');
    Route::post('cart', [CustomerController::class, 'addToCart'])->name('cart.add');
    Route::post('cart/remove', [CustomerController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('order', [CustomerController::class, 'placeOrder'])->name('order.place');
    Route::get('orders', [CustomerController::class, 'order'])->name('order.index');
    Route::post('orders', [CustomerController::class, 'orderShow'])->name('order.show');
    Route::get('order/{order}', [CustomerController::class, 'orderDetails'])->name('order.details');
    Route::get('', [UserProductController::class, 'index'])->name('products.index');
});
