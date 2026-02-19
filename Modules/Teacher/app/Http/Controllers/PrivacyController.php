<?php

namespace Modules\Teacher\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ExportUserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivacyController extends Controller
{
    public function export(Request $request)
    {
        ExportUserData::dispatch($request->user());

        return back()->with('success', 'A exportação dos seus dados começou. Você será notificado quando estiver pronta.');
    }

    public function delete(Request $request)
    {
        $user = $request->user();

        // Soft delete user
        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sua conta foi excluída com sucesso.');
    }
}
