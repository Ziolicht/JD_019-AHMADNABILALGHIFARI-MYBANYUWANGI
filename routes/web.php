<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Beranda (navbar pakai route('home'))
Route::get('/', [EventController::class, 'index'])->name('home');
// Halaman event utama (alias)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
// Lihat semua event
Route::get('/events/all', [EventController::class, 'list'])->name('events.list');
// Detail event
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
// Halaman tentang
Route::view('/about', 'layouts.about')->name('about');

/*
|--------------------------------------------------------------------------
| Auth Helpers
|--------------------------------------------------------------------------
| Untuk mencegah error pada route('logout') dan 'dashboard'
*/

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// Redirect dashboard ke home
Route::get('/dashboard', fn() => redirect()->route('home'))->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (CRUD Event)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin/events')->group(function () {
    Route::get('/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/', [EventController::class, 'store'])->name('events.store');
    Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});

/*
|--------------------------------------------------------------------------
| Auth routes (Breeze/Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
