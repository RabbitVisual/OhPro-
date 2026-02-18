<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-xl font-display font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <x-icon name="table-cells" style="duotone" />
            Rubricas
        </h1>
        <button type="button" wire:click="openNew"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
            <x-icon name="plus" style="duotone" class="fa-sm" />
            Nova rubrica
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($this->rubrics as $rubric)
                    <li class="flex items-center justify-between gap-2 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <button type="button" wire:click="edit({{ $rubric->id }})" class="flex-1 text-left min-w-0">
                            <span class="font-medium text-gray-900 dark:text-white block truncate">{{ $rubric->name }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $rubric->levels_count }} nível(is)</span>
                        </button>
                        <button type="button" wire:click="deleteRubric({{ $rubric->id }})" wire:confirm="Excluir esta rubrica?"
                            class="p-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <x-icon name="trash" style="duotone" class="fa-sm" />
                        </button>
                    </li>
                    @empty
                    <li class="p-6 text-center text-gray-500 dark:text-gray-400 text-sm">Nenhuma rubrica. Clique em "Nova rubrica" para criar.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="lg:col-span-2">
            @if($editingId !== null || $name !== '' || count($levels) > 0)
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4">{{ $editingId ? 'Editar rubrica' : 'Nova rubrica' }}</h2>
                <form wire:submit="save" class="space-y-4">
                    <div>
                        <label for="rubric-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome do critério</label>
                        <input type="text" id="rubric-name" wire:model="name" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                        @error('name') <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="rubric-desc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descrição (opcional)</label>
                        <textarea id="rubric-desc" wire:model="description" rows="2" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white"></textarea>
                    </div>
                    <div>
                        <label for="rubric-order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ordem</label>
                        <input type="number" id="rubric-order" wire:model="sort_order" min="0" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Níveis</span>
                            <button type="button" wire:click="addLevel" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">+ Adicionar nível</button>
                        </div>
                        @foreach($levels as $index => $level)
                        <div class="flex flex-wrap items-start gap-2 mb-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50" wire:key="level-{{ $index }}">
                            <input type="text" wire:model="levels.{{ $index }}.name" placeholder="Nome (ex.: Iniciante)" class="flex-1 min-w-[120px] rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2">
                            <input type="text" wire:model="levels.{{ $index }}.points" placeholder="Pontos (0-10)" class="w-20 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm py-2 text-center">
                            @if(count($levels) > 1)
                            <button type="button" wire:click="removeLevel({{ $index }})" class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded">
                                <x-icon name="trash" style="duotone" class="fa-sm" />
                            </button>
                            @endif
                        </div>
                        @error('levels.'.$index.'.name') <p class="text-sm text-red-600 dark:text-red-400 -mt-1 mb-1">{{ $message }}</p> @enderror
                        @error('levels.'.$index.'.points') <p class="text-sm text-red-600 dark:text-red-400 -mt-1 mb-1">{{ $message }}</p> @enderror
                        @endforeach
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                            <x-icon name="check" style="duotone" class="fa-sm" />
                            Salvar rubrica
                        </button>
                        <button type="button" wire:click="cancel" class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300">Cancelar</button>
                    </div>
                </form>
            </div>
            @else
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-8 text-center text-gray-500 dark:text-gray-400">
                <x-icon name="table-cells" style="duotone" class="fa-2x mx-auto mb-2 opacity-50" />
                <p>Selecione uma rubrica para editar ou crie uma nova.</p>
            </div>
            @endif
        </div>
    </div>
</div>
