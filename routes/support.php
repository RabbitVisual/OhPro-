<?php

use Illuminate\Support\Facades\Route;
use Modules\Support\Http\Controllers\PanelController;

/*
| Painel Support: apenas utilizadores com role "support".
*/

Route::middleware(['auth', 'verified', 'role:support'])->prefix('support')->name('panel.')->group(function () {
    Route::get('/', [PanelController::class, 'index'])->name('support');
    Route::get('/subscription', [PanelController::class, 'subscription'])->name('support.subscription');
});
