<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('plannings', PlanningController::class)->names('planning');
});
