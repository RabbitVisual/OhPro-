<?php

use Illuminate\Support\Facades\Route;
use Modules\Notebook\Http\Controllers\NotebookController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('notebooks', NotebookController::class)->names('notebook');
});
