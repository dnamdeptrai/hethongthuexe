<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\BookingController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route cho Client 
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('client.dashboard');
// Route chi tiết xe
Route::get('/xe/{id}', [HomeController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('client.car.detail');
// Route nhận dữ liệu đặt xe
Route::post('/dat-xe', [BookingController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('client.book.store');
Route::get('/thanh-toan/{id}', [BookingController::class, 'checkout'])
    ->middleware(['auth', 'verified'])
    ->name('client.checkout');
Route::post('/thanh-toan/{id}', [BookingController::class, 'processPayment'])
    ->middleware(['auth', 'verified'])
    ->name('client.process_payment');
Route::get('/gioi-thieu', function () { return view('client.about'); })->middleware(['auth'])->name('client.about');
Route::get('/dich-vu', function () { return view('client.services'); })->middleware(['auth'])->name('client.services');
Route::get('/lien-he', function () { return view('client.contact'); })->middleware(['auth'])->name('client.contact');
Route::get('/lich-su', [BookingController::class, 'history'])
    ->middleware(['auth', 'verified'])
    ->name('client.bookings.history');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route cho Admin
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
    })->name('admin.dashboard');
});


require __DIR__.'/auth.php';