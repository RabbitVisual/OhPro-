<?php

use Illuminate\Support\Facades\Route;

/*
| Teacher API routes. TeacherController currently only implements web actions
| (index, stats). Add apiResource or specific API endpoints here when needed.
*/
Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    // e.g. Route::apiResource('teachers', Api\TeacherController::class)->names('teacher');
});
