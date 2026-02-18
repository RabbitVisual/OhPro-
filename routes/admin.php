<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\PanelController;

/*
| Painel Admin: apenas utilizadores com role "admin".
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('panel.')->group(function () {
    Route::get('/', [\Modules\Admin\Http\Controllers\DashboardController::class, 'index'])->name('admin');
    Route::get('/users', [\Modules\Admin\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
    Route::post('/users/{user}/upgrade', [\Modules\Admin\Http\Controllers\UserController::class, 'upgradeToPro'])->name('admin.users.upgrade');
    Route::get('/plans', [\Modules\Admin\Http\Controllers\PlanManagerController::class, 'index'])->name('admin.plans.index');
    Route::get('/plans/{plan}/edit', [\Modules\Admin\Http\Controllers\PlanManagerController::class, 'edit'])->name('admin.plans.edit');
    Route::put('/plans/{plan}', [\Modules\Admin\Http\Controllers\PlanManagerController::class, 'update'])->name('admin.plans.update');
    Route::get('/tickets', [\Modules\Support\Http\Controllers\AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{ticket}', [\Modules\Support\Http\Controllers\AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::put('/tickets/{ticket}', [\Modules\Support\Http\Controllers\AdminTicketController::class, 'reply'])->name('admin.tickets.reply');
    Route::get('/health', [\Modules\Admin\Http\Controllers\HealthController::class, 'index'])->name('admin.health');
    Route::get('/subscriptions', [\Modules\Admin\Http\Controllers\PanelController::class, 'subscriptions'])->name('admin.subscriptions');
});
