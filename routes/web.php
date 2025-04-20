<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FiltersController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('products')->group(function () {
    Route::get('{category?}', [ProductsController::class, 'index'])
        ->where('category', '[a-zA-Z\-_\']+')
        ->name('products.index');

    Route::get('{category?}/{id}', [ProductsController::class, 'show'])
        ->where('category', '[a-zA-Z\-_\']+')
        ->where('id', '[0-9]+')
        ->name('products.show');

    Route::get('{id}', [ProductsController::class, 'show'])
        ->where('id', '[0-9]+')
        ->name('products.show');
});

Route::post('/filters', [FiltersController::class, 'index'])->name('filters.index');
    //    ->withoutMiddleware(VerifyCsrfToken::class);