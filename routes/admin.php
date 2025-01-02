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

    // Category Routes
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', \App\Livewire\Backend\Category\Index::class)->name('list');
        Route::get('create', \App\Livewire\Backend\Category\Create::class)->name('create');
        Route::get('{categoryId}/edit', \App\Livewire\Backend\Category\Create::class)->name('edit');
        // DataTable Route
        Route::prefix('dataTable')->group(function () {
            Route::post('/', \App\Actions\Category\CategoryTable::class)->name('data');
        });
    });

    // Product Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', \App\Livewire\Backend\Product\Index::class)->name('list');
        Route::get('create', \App\Livewire\Backend\Product\Create::class)->name('create');
        Route::get('{productId}/edit', \App\Livewire\Backend\Product\Create::class)->name('edit');
        // DataTable Route
        Route::prefix('dataTable')->group(function () {
            Route::post('/', \App\Actions\Product\ProductTable::class)->name('data');
        });
    });


});
