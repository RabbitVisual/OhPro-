<div class="p-4 md:p-6 space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="wallet" style="duotone" class="text-indigo-500" />
            Minha Carteira
        </h1>
        <div class="text-sm text-gray-500 dark:text-gray-400">
            Gerencie seus ganhos e saques
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Total Balance --}}
        <div class="rounded-xl bg-gradient-to-br from-indigo-600 to-indigo-700 p-6 text-white shadow-lg">
            <div class="flex items-center justify-between mb-4">
                <span class="text-indigo-100 font-medium">Saldo Total</span>
                <x-icon name="sack-dollar" style="duotone" size="xl" class="opacity-80" />
            </div>
            <div class="text-3xl font-bold">
                R$ {{ number_format($wallet->balance, 2, ',', '.') }}
            </div>
            <div class="mt-2 text-indigo-100 text-sm">
                Acumulado de vendas
            </div>
        </div>

        {{-- Withdrawable --}}
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-gray-500 dark:text-gray-400 font-medium">Disponível para Saque</span>
                <x-icon name="money-bill-transfer" style="duotone" size="xl" class="text-emerald-500" />
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                R$ {{ number_format($wallet->withdrawable_balance, 2, ',', '.') }}
            </div>
            <div class="mt-4">
                <button wire:click="requestWithdrawal"
                    @if($wallet->withdrawable_balance < 50) disabled title="Mínimo R$ 50,00" @endif
                    class="w-full py-2 px-4 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    Solicitar Saque
                </button>
            </div>
        </div>

        {{-- Sales Count --}}
        <div class="rounded-xl bg-white dark:bg-gray-800 p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-gray-500 dark:text-gray-400 font-medium">Vendas Realizadas</span>
                <x-icon name="cart-shopping" style="duotone" size="xl" class="text-blue-500" />
            </div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $wallet->transactions()->where('type', 'sale')->count() }}
            </div>
            <div class="mt-2 text-gray-500 dark:text-gray-400 text-sm">
                Produtos vendidos
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="font-semibold text-gray-900 dark:text-white">Histórico de Transações</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Descrição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Valor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                {{ $transaction->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->type === 'sale')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Venda
                                    </span>
                                @elseif($transaction->type === 'withdrawal')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                        Saque
                                    </span>
                                @elseif($transaction->type === 'fee')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Taxa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono font-medium {{ $transaction->amount > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $transaction->amount > 0 ? '+' : '' }} R$ {{ number_format(abs($transaction->amount), 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <x-icon name="receipt" style="duotone" size="2xl" class="mb-3 opacity-50" />
                                <p>Nenhuma transação encontrada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
