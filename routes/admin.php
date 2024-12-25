<?php

use App\Http\Middleware\AdminGuest;
use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Backend\Auth\Login;
use App\Livewire\Backend\Dashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(AdminGuest::class)->group(function () {
    Route::get('login', Login::class)->name('login');
});
Route::middleware(RoleMiddleware::class.':admin')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});
