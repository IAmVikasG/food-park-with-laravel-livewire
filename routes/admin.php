<?php

use App\Livewire\Backend\Auth\Login;
use App\Livewire\Backend\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('login', Login::class)->name('login');
Route::get('dashboard', Dashboard::class)->name('dashboard');
