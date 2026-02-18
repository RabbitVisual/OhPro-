<x-layouts.app title="Assinaturas — Admin">
    <div class="min-h-screen p-4 md:p-6">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">Assinaturas</h1>
                <a href="{{ route('panel.admin') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Voltar ao painel</a>
            </div>
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Usuário</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Plano</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Gateway</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Fim do período</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($subscriptions as $sub)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $sub->user?->email ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $sub->plan?->name ?? '—' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sub->gateway }}</td>
                                <td class="px-4 py-3 text-sm">{{ $sub->status }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $sub->current_period_end?->format('d/m/Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Nenhuma assinatura encontrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($subscriptions->hasPages())
                <div class="mt-4">{{ $subscriptions->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.app>
