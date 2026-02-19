<?php

use Illuminate\Support\Facades\Route;
use Modules\Teacher\Http\Controllers\TeacherController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('teachers', TeacherController::class)->names('teacher');

    // Privacy Routes
    Route::post('/profile/privacy/export', [\Modules\Teacher\Http\Controllers\PrivacyController::class, 'export'])->name('profile.privacy.export');
    Route::delete('/profile/privacy/delete', [\Modules\Teacher\Http\Controllers\PrivacyController::class, 'delete'])->name('profile.privacy.delete');

    // Teacher Stats
    Route::get('/stats', [\Modules\Teacher\Http\Controllers\TeacherController::class, 'stats'])->name('teacher.stats');

    // Wallet
    Route::get('/wallet', \Modules\Teacher\Livewire\WalletDashboard::class)->name('teacher.wallet');
});

Route::get('/pro/{username}', \Modules\Teacher\Livewire\PublicProfile::class)->name('public.profile');
