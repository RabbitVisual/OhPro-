<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleClassroomController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->scopes([
                'https://www.googleapis.com/auth/classroom.courses.readonly',
                'https://www.googleapis.com/auth/classroom.rosters.readonly',
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
            ])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Store token in session to be used by the Livewire wizard
            session(['google_token' => $googleUser->token]);
            session(['google_refresh_token' => $googleUser->refreshToken]);
            session(['google_user_email' => $googleUser->getEmail()]);

            return redirect()->route('workspace.import.google');
        } catch (\Exception $e) {
            return redirect()->route('workspace.index')->with('error', 'Falha na autenticação com Google.');
        }
    }
}
