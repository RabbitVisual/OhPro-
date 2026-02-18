<x-layouts.app-sidebar :title="$title ?? 'Gerenciar Planos'">
    <div class="min-h-screen p-4 md:p-6 space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                    Gerenciar Planos
                </h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Defina preços e limites para cada nível de assinatura.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($plans as $plan)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 flex flex-col h-full overflow-hidden">
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                            {{ $plan->key }}
                        </span>
                        @if($plan->is_active)
                            <span class="text-emerald-500 text-xs font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Ativo
                            </span>
                        @else
                             <span class="text-gray-400 text-xs font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Inativo
                            </span>
                        @endif
                    </div>

                    <h3 class="text-xl font-display font-bold text-gray-900 dark:text-white mb-2">
                        {{ $plan->name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-2">
                        {{ $plan->description ?? 'Sem descrição.' }}
                    </p>

                    <div class="mt-auto space-y-3">
                         <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Mensal</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $plan->formattedPriceMonthly() }}</span>
                        </div>
                         <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 dark:text-gray-400">Anual</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $plan->formattedPriceYearly() ?? '-' }}</span>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700/50 space-y-2">
                             <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500">Escolas</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $plan->getLimit('max_schools') ?? '∞' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500">Turmas</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $plan->getLimit('max_classes') ?? '∞' }}</span>
                            </div>
                             <div class="flex items-center justify-between text-xs">
                                <span class="text-gray-500">IA/mês</span>
                                <span class="font-medium text-gray-700 dark:text-gray-300">{{ $plan->getLimit('ai_plans_per_month') ?? '0' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-t border-gray-100 dark:border-gray-700/50">
                    <a href="{{ route('panel.admin.plans.edit', $plan) }}" class="block w-full text-center px-4 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Editar Detalhes
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app-sidebar>
