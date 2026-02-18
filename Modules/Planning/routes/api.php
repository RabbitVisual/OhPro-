<?php

use Illuminate\Support\Facades\Route;
use Modules\Planning\Http\Controllers\PlanningController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('plannings', PlanningController::class)->names('planning');
});
