<?php

use Illuminate\Support\Facades\Route;
use Modules\Diary\Http\Controllers\DiaryController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('diaries', DiaryController::class)->names('diary');
});
