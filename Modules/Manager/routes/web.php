<?php

use Illuminate\Support\Facades\Route;
use Modules\Manager\Http\Controllers\ManagerDashboardController;

Route::get('/', [ManagerDashboardController::class, 'index'])->name('index');
Route::get('/school/{school}', [ManagerDashboardController::class, 'dashboard'])->name('dashboard')->whereNumber('school');
Route::get('/school/{school}/diary-pdf', [ManagerDashboardController::class, 'diaryPdf'])->name('diary.pdf')->whereNumber('school');
