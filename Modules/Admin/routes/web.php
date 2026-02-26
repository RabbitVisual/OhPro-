<?php

use Illuminate\Support\Facades\Route;

/*
| O painel administrativo está em routes/admin.php (prefixo /admin, nome panel.admin.*).
| Este ficheiro não expõe resource admins para evitar views duplicadas e rotas órfãs.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Rotas específicas do módulo Admin, se necessário no futuro
});
