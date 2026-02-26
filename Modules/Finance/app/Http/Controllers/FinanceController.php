<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Finance\Models\Transaction;
use Modules\Finance\Models\Wallet;

class FinanceController extends Controller
{
    /**
     * Display wallet and transactions (Minhas Finanças).
     */
    public function index(): View
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => auth()->id()],
            ['balance' => 0, 'withdrawable_balance' => 0]
        );

        $transactions = $wallet->transactions()->latest()->paginate(15);

        return view('finance::index', compact('wallet', 'transactions'));
    }

    /**
     * Show the form for creating (not used; redirect).
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('finance.index');
    }

    /**
     * Store (not used for finances from this controller).
     */
    public function store(Request $request) {}

    /**
     * Show a single transaction detail.
     */
    public function show(string $id): View
    {
        $transaction = Transaction::whereHas('wallet', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('wallet')->findOrFail($id);

        return view('finance::show', compact('transaction'));
    }

    /**
     * Edit (not used; redirect).
     */
    public function edit(string $id): RedirectResponse
    {
        return redirect()->route('finance.index');
    }

    /**
     * Update (not used).
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove (not used).
     */
    public function destroy(string $id) {}
}
