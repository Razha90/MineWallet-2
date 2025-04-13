<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/aa', function () {
    return view('welcome');
})->name('house');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Volt::route('/', 'app')->name('home');
    Volt::route('/transaction', 'transaction')->name('transaction');
    Volt::route('/profile', 'profile')->name('profile');
    Volt::route('/admin', 'admin/home')->name('admin.home');

    Route::middleware([App\Http\Middleware\AdminMIddleware::class])->group(function () {
        Volt::route('/admin', 'admin/home')->name('admin.home');
    });
});

require __DIR__ . '/auth.php';
