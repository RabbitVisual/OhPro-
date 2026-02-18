<x-layouts.app-sidebar :title="$title ?? 'Editar Plano'">
    <div class="min-h-screen p-4 md:p-6 flex justify-center">
        <div class="w-full max-w-2xl space-y-6">
            {{-- Header --}}
             <div class="flex items-center gap-4">
                <a href="{{ route('panel.admin.plans.index') }}" class="p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                    <x-icon name="arrow-left" class="w-5 h-5" />
                </a>
                <div>
                    <h1 class="text-2xl font-display font-bold text-gray-900 dark:text-white">
                        {{ $plan->name }}
                    </h1>
                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                        {{ $plan->key }}
                    </span>
                </div>
            </div>

            <form action="{{ route('panel.admin.plans.update', $plan) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-6 md:p-8 space-y-8">
                    {{-- Pricing --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                             <x-icon name="tags" style="duotone" class="w-5 h-5 text-indigo-500" />
                            Preços
                        </h3>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Preço Mensal (R$)</label>
                                <input type="number" step="0.01" name="price_monthly" value="{{ old('price_monthly', $plan->price_monthly) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('price_monthly') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                             <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Preço Anual (R$)</label>
                                <input type="number" step="0.01" name="price_yearly" value="{{ old('price_yearly', $plan->price_yearly) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:ring-indigo-500 focus:border-indigo-500">
                                 @error('price_yearly') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 dark:border-gray-700">

                    {{-- Limits --}}
                    <div>
                         <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                             <x-icon name="sliders-h" style="duotone" class="w-5 h-5 text-indigo-500" />
                            Limites e Restrições
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Use -1 para ilimitado.</p>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/50">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Máximo de Escolas</label>
                                <input type="number" name="limits[max_schools]" value="{{ old('limits.max_schools', $plan->getLimit('max_schools')) }}" class="w-32 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-center focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                             <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/50">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Máximo de Turmas</label>
                                <input type="number" name="limits[max_classes]" value="{{ old('limits.max_classes', $plan->getLimit('max_classes')) }}" class="w-32 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-center focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                             <div class="flex items-center justify-between p-4 rounded-xl bg-gray-50 dark:bg-gray-900/30 border border-gray-100 dark:border-gray-700/50">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Gerações de IA / Mês</label>
                                <input type="number" name="limits[ai_plans_per_month]" value="{{ old('limits.ai_plans_per_month', $plan->getLimit('ai_plans_per_month')) }}" class="w-32 rounded-lg border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-center focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-4 border-t border-gray-100 dark:border-gray-700/50 flex justify-end gap-3">
                    <a href="{{ route('panel.admin.plans.index') }}" class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/20">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app-sidebar>
