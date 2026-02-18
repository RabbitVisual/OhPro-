<?php

use Illuminate\Support\Facades\Route;
use Modules\Manager\Http\Controllers\ManagerController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('managers', ManagerController::class)->names('manager');
});
