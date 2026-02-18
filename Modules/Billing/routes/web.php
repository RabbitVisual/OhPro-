<?php

use Illuminate\Support\Facades\Route;
use Modules\Billing\Http\Controllers\BillingController;

Route::middleware(['auth', 'verified'])->prefix('billing')->name('billing.')->group(function () {
    Route::get('/', [BillingController::class, 'index'])->name('index');
    Route::post('/checkout', [BillingController::class, 'checkout'])->name('checkout');
    Route::get('/success', [BillingController::class, 'success'])->name('success');
    Route::get('/cancel', [BillingController::class, 'cancel'])->name('cancel');
});
