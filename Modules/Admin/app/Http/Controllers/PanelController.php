<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Subscription;

class PanelController extends Controller
{
    /**
     * Display the admin panel dashboard.
     */
    public function index()
    {
        return view('admin::panel.index', ['title' => 'Painel Admin']);
    }

    /**
     * Display the subscriptions list.
     */
    public function subscriptions()
    {
        $subscriptions = Subscription::with(['user', 'plan'])->latest()->paginate(20);
        return view('admin::panel.subscriptions.index', compact('subscriptions'));
    }
}
