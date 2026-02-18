<?php

use Illuminate\Support\Facades\Route;
use Modules\Workspace\Http\Controllers\WorkspaceController;
use Modules\Planning\Http\Controllers\PlanningController;
use Modules\Notebook\Http\Controllers\NotebookController;
use Modules\Diary\Http\Controllers\DiaryController;
use Modules\ClassRecord\Http\Controllers\PdfReportController;
use Modules\ClassRecord\Http\Controllers\ShareReportController;
use Modules\ClassRecord\Http\Controllers\SendReportController;

Route::middleware(['auth', 'verified', 'role:teacher'])->group(function () {
    // Workspace (multi-school dashboard)
    Route::prefix('workspace')->name('workspace.')->group(function () {
        Route::get('/', [WorkspaceController::class, 'index'])->name('index');
        Route::get('/import', function () {
            return view('workspace::import');
        })->name('import')->middleware('pro');
        Route::get('/class/{schoolClass}', [WorkspaceController::class, 'show'])->name('show')->whereNumber('schoolClass');
        Route::post('/class/{schoolClass}/launch', [DiaryController::class, 'launch'])->name('launch');
    });

    // Diary (class diary / register)
    Route::get('/diary/class/{diary}', [DiaryController::class, 'show'])->name('diary.class.show')->whereNumber('diary');
    Route::get('/diary/class/{diary}/pdf', [PdfReportController::class, 'diary'])->name('diary.class.pdf')->whereNumber('diary')->middleware('pro');
    Route::get('/diary/class/{diary}/pdf/signed', [PdfReportController::class, 'diary'])->name('diary.class.pdf.signed')->whereNumber('diary')->middleware(['pro', 'signed']);

    // Share report (WhatsApp link data)
    Route::get('/connect/diary/{diary}/share-data', [ShareReportController::class, 'shareDiary'])->name('connect.diary.share')->whereNumber('diary')->middleware('pro');
    Route::get('/connect/report-card/{schoolClass}/share-data', [ShareReportController::class, 'shareReportCard'])->name('connect.report-card.share')->whereNumber('schoolClass')->middleware('pro');
    Route::post('/connect/send-email', [SendReportController::class, 'sendEmail'])->name('connect.send-email')->middleware('pro');

    // Notebook (grades & attendance)
    Route::prefix('notebook')->name('notebook.')->group(function () {
        Route::get('/class/{schoolClass}/grades', [NotebookController::class, 'grades'])->name('grades');
        Route::get('/class/{schoolClass}/attendance', [NotebookController::class, 'attendance'])->name('attendance');
        Route::get('/class/{schoolClass}/report-card/pdf', [PdfReportController::class, 'reportCard'])->name('report-card.pdf')->whereNumber('schoolClass')->middleware('pro');
        Route::get('/class/{schoolClass}/report-card/pdf/signed', [PdfReportController::class, 'reportCard'])->name('notebook.report-card.pdf.signed')->whereNumber('schoolClass')->middleware(['pro', 'signed']);
    });

    // Planning (lesson plans)
    Route::prefix('planning')->name('planning.')->group(function () {
        Route::get('/', [PlanningController::class, 'index'])->name('index');
        Route::get('/community', [PlanningController::class, 'community'])->name('community');
        Route::get('/create', [PlanningController::class, 'create'])->name('create');
        Route::post('/generate-with-ai', [PlanningController::class, 'generateWithAi'])->name('generate-with-ai');
        Route::post('/', [PlanningController::class, 'store'])->name('store');
        Route::post('/{id}/clone', [PlanningController::class, 'clone'])->name('clone')->whereNumber('id');
        Route::get('/{id}', [PlanningController::class, 'show'])->name('show')->whereNumber('id');
        Route::get('/{id}/edit', [PlanningController::class, 'edit'])->name('edit')->whereNumber('id');
        Route::put('/{id}', [PlanningController::class, 'update'])->name('update')->whereNumber('id');
        Route::delete('/{id}', [PlanningController::class, 'destroy'])->name('destroy')->whereNumber('id');
    });
});
