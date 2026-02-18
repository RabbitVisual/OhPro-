<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
| Painel Support: apenas utilizadores com role "support".
*/

Route::middleware(['auth', 'verified', 'role:support'])->prefix('support')->name('panel.')->group(function () {
    Route::get('/', function () {
        return response()->view('panels.support', ['title' => 'Painel Suporte'], 200);
    })->name('support');
    Route::get('/subscription', function (Request $request) {
        $user = null;
        $subscription = null;
        $email = $request->query('email');
        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $subscription = $user->subscription();
            }
        }
        return view('panels.support-subscription', ['user' => $user, 'subscription' => $subscription, 'searchedEmail' => $email]);
    })->name('support.subscription');
});
