<?php

use Illuminate\Support\Facades\Route;
use Modules\Workspace\Http\Controllers\WorkspaceController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/workspace', [WorkspaceController::class, 'index'])->name('workspace.index');
    Route::get('/workspace/class/{schoolClass}', [WorkspaceController::class, 'show'])->name('workspace.show');
    Route::get('/workspace/portfolio/{student}', [WorkspaceController::class, 'portfolio'])->name('workspace.portfolio');
});
