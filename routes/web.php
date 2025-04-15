<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/aa', function () {
    return view('welcome');
})->name('house');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('/', 'app')->name('home');
    Volt::route('/transaction', 'transaction')->name('transaction');
    Volt::route('/profile', 'profile')->name('profile');
    // Volt::route('/admin', 'admin/home')->name('admin.home');
    Volt::route('/topup', 'topup')->name('topup');
    Volt::route('/transfer', 'transfer')->name('transfer');
    Volt::route('/create-pin', 'payment/create-pin')->name('payment.create-pin');
    Volt::route('/topup/{id}', 'payment.topup-detail')->name('detail.topup');
    Volt::route('/transfer/{id}', 'payment.transfer-detail')->name('detail.transfer');
    Volt::route('/transaction/{id}','payment.transaction-detail')->name('detail.transaction');
    Volt::route('/pulsa', 'pulsa')->name('pulsa');
    


    Route::middleware([App\Http\Middleware\PinMiddleware::class])->group(function () {
        // Volt::route('/payment-gateway', 'admin/topup')->name('admin.topup');
        // Volt::route('/process-topup/{nom}/{bank}', 'payment/process-topup')->name('payment.process-topup');
        Volt::route('/payment-gateway', 'payment.gateway')->name('payment.gateway');
        Volt::route('/payment-detail/{id}/topup', 'payment/detail-payment')->name('payment.detail-payment');
        Volt::route('/payment-detail/{id}/transaction', 'payment/detail-transaction')->name('payment.detail-transaction');
        Volt::route('/payment-detail/{id}/transfer', 'payment/detail-transfer')->name('payment.detail-transfer');

    });

    Route::middleware([App\Http\Middleware\AdminMIddleware::class])->group(function () {
        Volt::route('/admin/buy', 'admin/buy')->name('admin.buy');
        Volt::route('/admin', 'admin/topup')->name('admin.topup');
        Volt::route('/admin/transfer', 'admin/transfer')->name('admin.transfer');
    });
});

require __DIR__ . '/auth.php';
