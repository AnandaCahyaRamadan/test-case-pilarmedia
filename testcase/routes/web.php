<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/job-orders', [JobOrderController::class, 'index'])->middleware('auth')->name('job-orders.index');
Route::get('/job-orders/create', [JobOrderController::class, 'create'])->name('job-orders.create');
Route::post('/job-orders', [JobOrderController::class, 'store'])->name('job-orders.store');
Route::post('/job-orders/get-cost', [JobOrderController::class, 'getCost']);
Route::get('/job-orders/cities/{provinceId}', [JobOrderController::class, 'getCities']);
Route::get('/job-orders/{id}', [JobOrderController::class, 'show'])
    ->middleware('auth')
    ->name('job-orders.show');