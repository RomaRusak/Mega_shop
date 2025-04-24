<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FiltersController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

Route::prefix('api/products')->group(function () {
    //если заканчивается на -\d+ то передан slug, а не категория
    Route::get('{productSlug}', [ProductsController::class, 'show'])
        ->where('productSlug', '^[a-zA-Z0-9-_]+-\d+$') 
        ->name('products.show');

    Route::get('{categorySlug?}', [ProductsController::class, 'index'])
        ->name('products.index');

    Route::get('{categorySlug}/{productSlug}', [ProductsController::class, 'show'])
        ->name('products.show');

});

Route::post('/api/filters', [FiltersController::class, 'index'])->name('filters.index')
       ->withoutMiddleware(VerifyCsrfToken::class);