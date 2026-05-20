<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Models\Car;

Route::get('/', function () {
    return redirect()->route('login');
});

// Route cho Client
Route::get('/dashboard', function () {
    $cars = Car::where('status', 'Sẵn sàng')->get(); 
        return view('client.home_page', compact('cars')); 
})->middleware(['auth', 'verified'])->name('client.dashboard');
Route::get('/gioi-thieu', function () { return view('client.about'); })->middleware(['auth'])->name('client.about');
Route::get('/dich-vu', function () { return view('client.services'); })->middleware(['auth'])->name('client.services');
Route::get('/lien-he', function () { return view('client.contact'); })->middleware(['auth'])->name('client.contact');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Route cho Admin
    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard'); 
        })->name('admin.dashboard');
    });
});

require __DIR__.'/auth.php';