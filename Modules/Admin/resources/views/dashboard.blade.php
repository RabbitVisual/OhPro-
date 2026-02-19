<x-layouts.app-sidebar :title="$title ?? 'Painel Admin'">
    <div class="min-h-screen p-4 md:p-6 space-y-8">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                    Visão Geral
                </h1>
                <p class="mt-1 text-gray-600 dark:text-gray-400">
                    Acompanhe as métricas principais do sistema.
                </p>
            </div>

            {{-- Quick Actions --}}
            <div class="flex items-center gap-3">
                 <a href="{{ route('panel.admin.subscriptions') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                    <x-icon name="credit-card" style="duotone" class="w-4 h-4 text-gray-500" />
                    <span>Assinaturas</span>
                </a>
            </div>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Teachers --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-indigo-500/20 to-purple-500/20 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>

                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Professores
                        </p>
                        <h3 class="mt-2 text-3xl font-display font-bold text-gray-900 dark:text-white">
                            {{ number_format($metrics['teachers_count']) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400">
                        <x-icon name="chalkboard-teacher" style="duotone" class="w-6 h-6" />
                    </div>
                </div>
            </div>

            {{-- Schools --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-emerald-500/20 to-teal-500/20 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>

                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Escolas
                        </p>
                        <h3 class="mt-2 text-3xl font-display font-bold text-gray-900 dark:text-white">
                            {{ number_format($metrics['schools_count']) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-xl text-emerald-600 dark:text-emerald-400">
                        <x-icon name="school" style="duotone" class="w-6 h-6" />
                    </div>
                </div>
            </div>

            {{-- MRR --}}
            <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-gray-800 p-6 shadow-sm border border-gray-100 dark:border-gray-700/50 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>

                <div class="relative flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            MRR (Estimado)
                        </p>
                        <h3 class="mt-2 text-3xl font-display font-bold text-gray-900 dark:text-white">
                            R$ {{ number_format($metrics['mrr'], 2, ',', '.') }}
                        </h3>
                    </div>
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-xl text-amber-600 dark:text-amber-400">
                        <x-icon name="chart-line-up" style="duotone" class="w-6 h-6" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Content Placeholder --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                 <livewire:admin.security-feed />
            </div>
             <div class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white p-6 rounded-2xl shadow-lg flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold">Status do Sistema</h3>
                    <p class="text-indigo-100 text-sm mt-1">Todos os serviços operando normalmente.</p>
                </div>
                <div class="mt-6 space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span>Banco de Dados</span>
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-100 border border-emerald-500/30 text-xs">Online</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span>Filas (Redis)</span>
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-100 border border-emerald-500/30 text-xs">Online</span>
                    </div>
                     <div class="flex items-center justify-between text-sm">
                        <span>Google Sync</span>
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-100 border border-emerald-500/30 text-xs">Ativo</span>
                    </div>
                </div>
             </div>
        </div>
    </div>
</x-layouts.app-sidebar>
