<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/s/{url}', [\App\Http\Controllers\UrlController::class, 'to'])->name('url.redirect');
Route::get('/qr/{url}', [\App\Http\Controllers\UrlController::class, 'to'])->name('qr.redirect');

Route::middleware([
    'auth:sanctum', config('jetstream.auth_session'), 'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('dashboard/')->name('dashboard.')->group(function () {
        Route::prefix('links')->name('links.')->group(function () {
            Route::get('/', \App\Livewire\Urls\Index::class)->name('index');
            Route::get('create', \App\Livewire\Urls\Create::class)->name('create');
            Route::get('edit/{db_url}', \App\Livewire\Urls\Edit::class)->name('edit');
            Route::get('details/{db_url}', \App\Livewire\Urls\Show::class)->name('show');
        });
    });
});
