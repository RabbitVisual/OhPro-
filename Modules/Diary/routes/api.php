<?php

use Illuminate\Support\Facades\Route;
use Modules\Diary\Http\Controllers\DiaryController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('diaries', DiaryController::class)->names('diary');
});
