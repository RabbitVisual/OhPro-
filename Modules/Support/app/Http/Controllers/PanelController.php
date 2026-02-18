<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Display the support panel dashboard.
     */
    public function index()
    {
        return view('support::panel.index', ['title' => 'Painel Suporte']);
    }

    /**
     * Display the subscription lookup page.
     */
    public function subscription(Request $request)
    {
        $user = null;
        $subscription = null;
        $email = $request->query('email');
        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $subscription = $user->subscription();
            }
        }
        return view('support::panel.subscription.index', [
            'user' => $user,
            'subscription' => $subscription,
            'searchedEmail' => $email
        ]);
    }
}
