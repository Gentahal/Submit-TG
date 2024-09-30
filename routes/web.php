<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Merchant routes
Route::prefix('merchant')->name('merchant.')->group(function () {
    // Public routes
    Route::get('register', [MerchantController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [MerchantController::class, 'register']);
    Route::get('login', [MerchantController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MerchantController::class, 'login']);
    
    // Protected routes
    Route::middleware(['auth.merchant'])->group(function () {
        Route::post('logout', [MerchantController::class, 'logout'])->name('logout');
        Route::get('dashboard', [MerchantController::class, 'dashboard'])->name('dashboard');
        Route::put('profile', [MerchantController::class, 'updateProfile'])->name('profile.update');
        
        // Menu management
        Route::resource('menu', MenuController::class);
        
        // Order management
        Route::get('orders', [OrderController::class, 'merchantOrders'])->name('orders');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('order.status');
        
        // Invoice management
        Route::get('invoices', [InvoiceController::class, 'merchantInvoices'])->name('invoices');
    });
});

// Customer routes
Route::prefix('customer')->name('customer.')->group(function () {
    // Public routes
    Route::get('register', [CustomerController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [CustomerController::class, 'register']);
    Route::get('login', [CustomerController::class, 'showLoginForm'])->name('login');
    Route::post('login', [CustomerController::class, 'login']);
    
    // Protected routes
    Route::middleware(['auth.customer'])->group(function () {
        Route::post('logout', [CustomerController::class, 'logout'])->name('logout');
        Route::get('dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('search', [CustomerController::class, 'search'])->name('search');
        Route::get('merchant/{merchant}', [CustomerController::class, 'viewMerchant'])->name('view_merchant');
        
        // Order management
        Route::post('order/{menu}', [OrderController::class, 'store'])->name('order.store');
        Route::get('orders', [OrderController::class, 'customerOrders'])->name('orders');
        
        // Invoice management
        Route::get('invoices', [InvoiceController::class, 'customerInvoices'])->name('invoices');
    });
});

// Shared routes (accessible by both merchants and customers)
Route::middleware(['auth'])->group(function () {
    Route::get('invoice/{invoice}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('invoice/{invoice}/pay', [InvoiceController::class, 'pay'])->name('invoice.pay');
});