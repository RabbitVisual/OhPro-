<?php

namespace Modules\Teacher\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Modules\Finance\Models\Wallet;
use Modules\Finance\Models\Transaction;

class WalletDashboard extends Component
{
    use WithPagination;

    public function getWalletProperty()
    {
        return Wallet::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0, 'withdrawable_balance' => 0]
        );
    }

    public function requestWithdrawal()
    {
        $wallet = $this->wallet;

        if ($wallet->withdrawable_balance < 50) {
            $this->dispatch('notify', type: 'error', message: 'Mínimo de R$ 50,00 para saque.');
            return;
        }

        // Logic to create a withdrawal request (e.g. create a support ticket or a specific WithdrawalRequest model)
        // For now, we simulate a deduction and a transaction record.

        \DB::transaction(function () use ($wallet) {
            $amount = $wallet->withdrawable_balance;

            $wallet->decrement('withdrawable_balance', $amount);
            $wallet->decrement('balance', $amount); // Assuming balance reflects total holding including withdrawable

            Transaction::create([
                'wallet_id' => $wallet->id,
                'amount' => -$amount,
                'type' => 'withdrawal',
                'description' => 'Solicitação de Saque',
                'metadata' => ['status' => 'pending']
            ]);
        });

        $this->dispatch('notify', type: 'success', message: 'Solicitação de saque enviada com sucesso!');
    }

    public function render()
    {
        $transactions = $this->wallet->transactions()->latest()->paginate(10);

        return view('teacher::livewire.wallet-dashboard', [
            'wallet' => $this->wallet,
            'transactions' => $transactions
        ])->layout('layouts.app-sidebar', ['title' => 'Carteira — Oh Pro!']);
    }
}
