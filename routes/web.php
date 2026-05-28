<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\DriverServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\ContactController;

use Illuminate\Support\Facades\Artisan;

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
// Route cho thanh toán
Route::get('/thanh-toan/{id}', [BookingController::class, 'checkout'])
    ->middleware(['auth', 'verified'])
    ->name('client.checkout');
Route::post('/thanh-toan/{id}', [BookingController::class, 'processPayment'])
    ->middleware(['auth', 'verified'])
    ->name('client.process_payment');
Route::get('/gioi-thieu', function () { return view('client.about'); })->middleware(['auth'])->name('client.about');
Route::get('/dich-vu', function () { return view('client.services'); })->middleware(['auth'])->name('client.services');

Route::post('/contact/submit', [ContactController::class, 'store'])->name('contact.store');Route::get('/thue-xe-co-nguoi-lai', DriverServiceController::class)->name('services.driver');

Route::get('/lich-su', [BookingController::class, 'history'])
    ->middleware(['auth', 'verified'])
    ->name('client.bookings.history');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::get('/lien-he', [ContactController::class, 'index'])->name('client.contact');
Route::post('/contact/submit', [ContactController::class, 'store'])->name('contact.store');

// Route cho Admin
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')    
    ->name('admin.')    
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('booking');
        Route::patch('/bookings/{id}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.update_status');
        
        Route::patch('/cars/{id}/status', [CarController::class, 'updateStatus'])->name('cars.update_status');
        Route::resource('cars', App\Http\Controllers\Admin\CarController::class);

        Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);

        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');

        Route::get('/setup-db', function () {
            try {
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                Artisan::call('migrate', ['--force' => true]);
                
                return '<h1> Xoá bộ nhớ đệm và Tạo Database thành công!</h1>';
            } catch (\Exception $e) {
                return '<h1> Lỗi:</h1>' . $e->getMessage();
            }
        });
});
require __DIR__.'/auth.php';

require __DIR__.'/auth.php';