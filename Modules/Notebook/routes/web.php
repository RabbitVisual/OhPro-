<?php

use Illuminate\Support\Facades\Route;
use Modules\Notebook\Http\Controllers\NotebookController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('notebook/classes/{schoolClass}/print-qrcodes', [Modules\Notebook\Http\Controllers\StudentCardController::class, 'print'])->name('notebook.classes.print-cards');
    Route::resource('notebooks', NotebookController::class)->names('notebook');
});
