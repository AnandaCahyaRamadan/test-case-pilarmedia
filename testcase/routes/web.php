<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [JobOrderController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::get('/job-orders/{id}', [JobOrderController::class, 'show'])
    ->middleware('auth')
    ->name('job-orders.show');