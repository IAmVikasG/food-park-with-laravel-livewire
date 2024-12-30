<?php

use Illuminate\Support\Facades\Route;

Route::middleware(\App\Http\Middleware\AdminGuest::class)->group(function () {
    Route::get('login', \App\Livewire\Backend\Auth\Login::class)->name('login');
});
Route::middleware(\App\Http\Middleware\RoleMiddleware::class.':admin')->group(function () {
    Route::get('dashboard', \App\Livewire\Backend\Dashboard::class)->name('dashboard');

    // Slider Routes
    Route::prefix('sliders')->name('sliders.')->group(function () {
        Route::get('/', \App\Livewire\Backend\Slider\Index::class)->name('list');
        Route::get('create', \App\Livewire\Backend\Slider\Create::class)->name('create');
        Route::get('{sliderId}/edit', \App\Livewire\Backend\Slider\Create::class)->name('edit');
        // DataTable Route
        Route::prefix('dataTable')->group(function () {
            Route::post('/', \App\Actions\Slider\SliderTable::class)->name('data');
        });
    });



});
