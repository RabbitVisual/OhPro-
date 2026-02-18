<x-layouts.app title="Assinatura do usuário — Suporte">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('panel.support') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Voltar ao painel</a>
            </div>
            <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white mb-4">Consultar assinatura</h1>
            <form method="get" action="{{ route('panel.support.subscription') }}" class="flex gap-2 mb-8">
                <input type="email" name="email" value="{{ old('email', $searchedEmail) }}" placeholder="E-mail do usuário" class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-white">
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700">Buscar</button>
            </form>
            @if($searchedEmail !== null)
                @if($user)
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $user->full_name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $user->email }}</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Plano (membership):</strong> {{ $user->membership ?? 'free' }}</p>
                        @if($subscription)
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-2"><strong>Assinatura:</strong> {{ $subscription->plan?->name }} — {{ $subscription->status }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gateway: {{ $subscription->gateway }} · Fim do período: {{ $subscription->current_period_end?->format('d/m/Y') ?? '—' }}</p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Sem assinatura ativa (plano gratuito).</p>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">Nenhum usuário encontrado com este e-mail.</p>
                @endif
            @endif
        </div>
    </div>
</x-layouts.app>
