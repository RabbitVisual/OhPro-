<div class="mb-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center justify-between gap-2">
        <span class="flex items-center gap-2"><x-icon name="money-bill-trend-up" style="duotone" /> Visão financeira</span>
        <a href="{{ route('teacher.wallet') }}" class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:underline">
            Minha Carteira &rarr;
        </a>
    </h2>
    @if(auth()->user()->hourly_rate !== null)
    @php $data = $this->data; @endphp
    <p class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
        Renda estimada este mês: R$ {{ number_format($data['total'] ?? 0, 2, ',', '.') }}
    </p>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Com base na sua grade de aulas e no valor por hora do perfil.</p>
    @if(count($data['by_school'] ?? []) > 0)
    @php $totalAmount = $data['total'] > 0 ? $data['total'] : 1; @endphp
    <div class="space-y-3">
        @foreach($data['by_school'] as $item)
        <div>
            <div class="flex justify-between text-sm mb-0.5">
                <span class="text-gray-700 dark:text-gray-300 truncate mr-2">{{ $item['school_name'] }}</span>
                <span class="text-gray-900 dark:text-white font-medium shrink-0">R$ {{ number_format($item['amount'], 2, ',', '.') }}</span>
            </div>
            <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden">
                <div class="h-full rounded-full bg-indigo-500 dark:bg-indigo-600 transition-all" style="width: {{ min(100, round(($item['amount'] / $totalAmount) * 100)) }}%"></div>
            </div>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ number_format($item['hours_per_month'], 1, ',', '') }} h/mês</p>
        </div>
        @endforeach
    </div>
    @else
    <p class="text-sm text-gray-500 dark:text-gray-400">Adicione turmas com horários para ver a distribuição por escola.</p>
    @endif
    @else
    <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Configure seu valor por hora no perfil para ver a renda estimada.</p>
    <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
        <x-icon name="user-pen" style="duotone" class="fa-sm" />
        Ir ao perfil
    </a>
    @endif
</div>
