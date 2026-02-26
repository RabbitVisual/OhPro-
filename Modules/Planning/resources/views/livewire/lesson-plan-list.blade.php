<div class="w-full p-4 md:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="book-open-reader" style="duotone" />
            Planos de aula
        </h1>
        <div class="flex gap-2">
            <a href="{{ route('planning.community') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-800">
                <x-icon name="globe-americas" style="duotone" class="fa-sm" />
                Galeria da Comunidade
            </a>
            <a href="{{ route('planning.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                <x-icon name="plus" style="duotone" class="fa-sm" />
                Criar plano
            </a>
        </div>
    </div>

    @if(session('success'))
        <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="mb-4 text-sm text-red-600 dark:text-red-400">{{ session('error') }}</p>
    @endif

    {{-- Desktop table --}}
    <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Título</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Template</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Turmas</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Atualizado</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($plans as $plan)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $plan->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $plan->template_key }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $plan->school_classes_count }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $plan->updated_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right text-sm">
                            <a href="{{ route('planning.edit', $plan->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Editar</a>
                            <a href="{{ route('planning.show', $plan->id) }}" class="ml-3 text-gray-600 dark:text-gray-400 hover:underline">Ver</a>
                            <button wire:click="$dispatch('open-publish-modal', { type: 'lesson_plan', id: {{ $plan->id }} })" class="ml-3 text-emerald-600 dark:text-emerald-400 hover:underline">Vender</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Nenhum plano ainda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($plans->hasPages())
            <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700">
                {{ $plans->links() }}
            </div>
        @endif
    </div>

    {{-- Mobile cards --}}
    <div class="md:hidden space-y-4">
        @forelse($plans as $plan)
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white">{{ $plan->title }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $plan->template_key }} · {{ $plan->school_classes_count }} turma(s)</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $plan->updated_at->format('d/m/Y') }}</p>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('planning.edit', $plan->id) }}" class="text-sm text-indigo-600 dark:text-indigo-400">Editar</a>
                    <a href="{{ route('planning.show', $plan->id) }}" class="text-sm text-gray-600 dark:text-gray-400">Ver</a>
                    <button wire:click="$dispatch('open-publish-modal', { type: 'lesson_plan', id: {{ $plan->id }} })" class="text-sm text-emerald-600 dark:text-emerald-400">Vender</button>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 dark:text-gray-400 py-8">Nenhum plano ainda.</p>
        @endforelse
        @if($plans->hasPages())
            {{ $plans->links() }}
        @endif
    </div>

    <livewire:marketplace.publish-item />
</div>
