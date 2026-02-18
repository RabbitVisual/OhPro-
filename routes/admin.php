<?php

use Illuminate\Support\Facades\Route;

/*
| Painel Admin: apenas utilizadores com role "admin".
| Rotas específicas serão adicionadas aqui (ex.: gestão de usuários, relatórios).
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('panel.')->group(function () {
    Route::get('/', function () {
        return response()->view('panels.admin', ['title' => 'Painel Admin'], 200);
    })->name('admin');
});
