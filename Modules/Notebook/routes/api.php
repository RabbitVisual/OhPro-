<?php

use Illuminate\Support\Facades\Route;
use Modules\Notebook\Http\Controllers\NotebookController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('notebooks', NotebookController::class)->names('notebook');
});
