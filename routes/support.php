<?php

use Illuminate\Support\Facades\Route;

/*
| Painel Support: apenas utilizadores com role "support".
| Rotas específicas serão adicionadas aqui (ex.: tickets, FAQ interno).
*/

Route::middleware(['auth', 'verified', 'role:support'])->prefix('support')->name('panel.')->group(function () {
    Route::get('/', function () {
        return response()->view('panels.support', ['title' => 'Painel Suporte'], 200);
    })->name('support');
});
