<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// 1. Rute Sisi Pelanggan (Customer Publik)
Route::get('/', [OrderController::class, 'index'])->name('customer.index');
Route::get('/track', [OrderController::class, 'track'])->name('orders.track');
Route::get('/orders/{order_code}/receipt', [OrderController::class, 'receipt'])->name('orders.receipt');

// Middleware 'auth' memastikan pelanggan harus login saat checkout pesanan laundry
Route::post('/checkout', [OrderController::class, 'store'])->middleware('auth')->name('customer.checkout');

// 2. Rute Dashboard Rekap Pesanan (Admin & Pelanggan)
Route::get('/dashboard', [OrderController::class, 'adminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 3. Rute Pengguna Terdaftar (Profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Rute Khusus Administrator
Route::middleware(['auth', 'admin'])->group(function () {
    // Update status cucian & status pembayaran
    Route::patch('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::patch('/admin/orders/{id}/payment', [OrderController::class, 'updatePaymentStatus'])->name('admin.orders.updatePayment');
    Route::delete('/admin/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    // CRUD Master Layanan Laundry
    Route::resource('/admin/services', ServiceController::class);
});

// Panggil rute login/logout Breeze bawaan
require __DIR__.'/auth.php';
