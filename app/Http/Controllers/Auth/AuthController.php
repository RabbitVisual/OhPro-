<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('HomePage::auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required_without:cpf', 'nullable', 'email'],
            'cpf' => ['required_without:email', 'nullable', 'string'],
            'password' => ['required', 'string'],
        ], [], [
            'email' => 'e-mail',
            'cpf' => 'CPF',
            'password' => 'senha',
        ]);

        $user = null;
        if (! empty($credentials['email'])) {
            $user = User::where('email', $credentials['email'])->first();
        } elseif (! empty($credentials['cpf'])) {
            $cpf = preg_replace('/\D/', '', $credentials['cpf']);
            $user = User::whereRaw('REPLACE(REPLACE(REPLACE(cpf, ".", ""), "-", ""), " ", "") = ?', [$cpf])->first();
        }

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors(['email' => __('As credenciais informadas não conferem.')])->withInput($request->only('email', 'cpf'));
        }

        Auth::login($user, (bool) $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function showRegisterForm(): View
    {
        return view('HomePage::auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'cpf' => ['required', 'string', 'max:20', 'unique:users,cpf'],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'password' => ['required', 'string', 'confirmed', PasswordRule::defaults()],
        ], [], [
            'first_name' => 'nome',
            'last_name' => 'sobrenome',
            'email' => 'e-mail',
            'cpf' => 'CPF',
            'phone' => 'telefone',
            'birth_date' => 'data de nascimento',
            'password' => 'senha',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        $user->assignRole('teacher');

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function showForgotPasswordForm(): View
    {
        return view('HomePage::auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']], [], ['email' => 'e-mail']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
