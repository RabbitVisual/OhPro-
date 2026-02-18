<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Modules\HomePage\Http\Controllers\HomePageController;

/*
| Rotas públicas centralizadas (módulo HomePage).
| Página inicial e páginas estáticas.
*/

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/terms', [HomePageController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomePageController::class, 'privacy'])->name('privacy');
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');
Route::get('/about', [HomePageController::class, 'about'])->name('about');
Route::get('/faq', [HomePageController::class, 'faq'])->name('faq');
Route::get('/planos', [HomePageController::class, 'plans'])->name('plans');

/*
| Autenticação (login, registro, logout, recuperação de senha).
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
| Webhooks (Stripe, Mercado Pago) - CSRF excluded in bootstrap/app.php
*/
Route::post('/webhooks/stripe', \Modules\Billing\Http\Controllers\StripeWebhookController::class)->name('webhooks.stripe');
Route::post('/webhooks/mercadopago', \Modules\Billing\Http\Controllers\MercadoPagoWebhookController::class)->name('webhooks.mercadopago');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/preferences', [App\Http\Controllers\ProfileController::class, 'updatePreferences'])->name('profile.preferences.update');
    Route::put('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->hasRole('teacher')) {
            return redirect()->route('workspace.index');
        }
        if ($user->hasRole('admin')) {
            return redirect()->route('panel.admin');
        }
        if ($user->hasRole('support')) {
            return redirect()->route('panel.support');
        }
        return redirect()->route('home')->with('error', __('Sem acesso a nenhum painel.'));
    })->name('dashboard');

    Route::get('/api/quick-search', \Modules\Core\Http\Controllers\QuickSearchController::class)->name('api.quick-search');
    Route::resource('homepages', HomePageController::class)->names('homepage');
});
