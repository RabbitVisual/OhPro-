<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\SupportController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [\Modules\Support\Http\Controllers\TeacherSupportController::class, 'index'])->name('support.index');
    Route::resource('supports', SupportController::class)->names('support');
});
