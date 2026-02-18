<?php

use App\Models\Subscription;
use Illuminate\Support\Facades\Route;

/*
| Painel Admin: apenas utilizadores com role "admin".
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('panel.')->group(function () {
    Route::get('/', function () {
        return response()->view('panels.admin', ['title' => 'Painel Admin'], 200);
    })->name('admin');
    Route::get('/subscriptions', function () {
        $subscriptions = Subscription::with(['user', 'plan'])->latest()->paginate(20);
        return view('panels.admin-subscriptions', ['subscriptions' => $subscriptions]);
    })->name('admin.subscriptions');
});
