<?php

use Illuminate\Support\Facades\Route;
use Modules\ClassRecord\Http\Controllers\ClassRecordController;

Route::get('/portal/{token}', [\Modules\ClassRecord\Http\Controllers\GuestPortfolioController::class, 'show'])->name('portal.guest');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('classrecords', ClassRecordController::class)->names('classrecord')->only(['index', 'show']);
    Route::get('/google/redirect', [\Modules\ClassRecord\Http\Controllers\GoogleClassroomController::class, 'redirect'])->name('google.redirect');
    Route::get('/google/callback', [\Modules\ClassRecord\Http\Controllers\GoogleClassroomController::class, 'callback'])->name('google.callback');
    Route::get('/import/google', \Modules\ClassRecord\Livewire\ImportGoogleRoster::class)->name('workspace.import.google');
});
