<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // Booking Routes
    Route::get('/bookings-admin', [BookingController::class, 'bookingAdmin'])->name('booking-admin');
    Route::post('booking-admin-store', [BookingController::class, 'storeBookingAdmin'])->name('store-booking-admin');
    Route::put('/booking/{id}', [BookingController::class, 'updateBooking'])->name('updateBooking');
    Route::delete('/booking/{id}', [BookingController::class, 'destroyBooking'])->name('destroyBooking');

    // Lapangan Routes
    Route::get('/lapangan-admin', [LapanganController::class, 'index'])->name('lapangan-page');
    Route::post('lapangan-admin-store', [LapanganController::class, 'store'])->name('store-lapangan');
    Route::put('/lapangan-admin/{id}', [LapanganController::class, 'update'])->name('update-lapangan');
    Route::delete('/lapangan-admin/{id}', [LapanganController::class, 'destroy'])->name('delete-lapangan');
});


// peminjam
Route::get('/', [BookingController::class, 'homePeminjam']);
Route::get('/bookings', [BookingController::class, 'bookingPeminjam'])->name('booking-page');
Route::post('/bookings', [BookingController::class, 'store'])->name('storeBooking');
Route::put('/bookings/{id}', [BookingController::class, 'update']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
Route::get('/api/booking', [BookingController::class, 'fetchBookings']);

