<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('plannings/{planning}/pdf', [PlanningController::class, 'downloadPdf'])->name('planning.pdf');
    Route::resource('plannings', PlanningController::class)->names('planning');
});
