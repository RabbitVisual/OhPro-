<?php

use Illuminate\Support\Facades\Route;
use Modules\Library\Http\Controllers\LibraryController;

Route::middleware(['auth', 'verified'])->prefix('library')->name('library.')->group(function () {
    Route::get('/', [LibraryController::class, 'index'])->name('index');
    Route::post('/', [LibraryController::class, 'store'])->name('store');
    Route::get('/{libraryFile}/download', [LibraryController::class, 'download'])->name('download')->whereNumber('libraryFile');
    Route::delete('/{libraryFile}', [LibraryController::class, 'destroy'])->name('destroy')->whereNumber('libraryFile');
});
