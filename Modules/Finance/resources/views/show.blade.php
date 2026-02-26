<x-layouts.app-sidebar title="Detalhe da transação — Oh Pro!">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('finance.index') }}" class="text-sm text-slate-600 dark:text-slate-400 hover:underline flex items-center gap-1 mb-6 w-fit">
            <x-icon name="arrow-left" style="duotone" class="fa-sm" />
            Voltar às Finanças
        </a>

        <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h1 class="text-xl font-display font-bold text-slate-900 dark:text-white">Detalhe da transação</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $transaction->created_at->translatedFormat('d/m/Y H:i') }}</p>
            </div>
            <dl class="p-6 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Tipo</dt>
                    <dd class="mt-1 text-slate-900 dark:text-white">
                        @if($transaction->type === 'sale')
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Venda</span>
                        @elseif($transaction->type === 'withdrawal')
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">Saque</span>
                        @else
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300">{{ ucfirst($transaction->type ?? 'Outro') }}</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Valor</dt>
                    <dd class="mt-1 text-lg font-semibold font-mono {{ $transaction->amount >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $transaction->amount >= 0 ? '+' : '' }} R$ {{ number_format(abs((float) $transaction->amount), 2, ',', '.') }}
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Descrição</dt>
                    <dd class="mt-1 text-slate-900 dark:text-white">{{ $transaction->description }}</dd>
                </div>
                @if(! empty($transaction->metadata))
                    <div>
                        <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Detalhes</dt>
                        <dd class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                            <pre class="whitespace-pre-wrap font-sans">{{ json_encode($transaction->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</x-layouts.app-sidebar>
