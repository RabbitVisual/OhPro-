<?php

use Illuminate\Support\Facades\Route;
use Modules\Teacher\Http\Controllers\TeacherController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Teacher Dashboard
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('teacher.index');
    Route::get('/stats', [TeacherController::class, 'stats'])->name('teacher.stats');

    // Privacy Routes
    Route::post('/profile/privacy/export', [\Modules\Teacher\Http\Controllers\PrivacyController::class, 'export'])->name('profile.privacy.export');
    Route::delete('/profile/privacy/delete', [\Modules\Teacher\Http\Controllers\PrivacyController::class, 'delete'])->name('profile.privacy.delete');

    // Wallet
    Route::get('/wallet', \Modules\Teacher\Livewire\WalletDashboard::class)->name('teacher.wallet');
});

Route::get('/pro/{username}', \Modules\Teacher\Livewire\PublicProfile::class)->name('public.profile');
