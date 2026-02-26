<div class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
    <h2 class="text-lg font-display font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <x-icon name="file-import" style="duotone" />
        Importar alunos
    </h2>

    @if($step === 1)
        <form wire:submit.prevent="updatedFile">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Arquivo CSV</label>
            <input type="file" wire:model="file" accept=".csv,.txt"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/30 dark:file:text-indigo-300 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50">
            @error('file')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Envie um CSV com colunas (ex.: Nome, Matrícula). Na próxima etapa você mapeia as colunas.</p>
        </form>
    @else
        <div class="space-y-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">Pré-visualização (primeiras linhas). Mapeie as colunas e escolha a turma.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coluna para Nome</label>
                    <select wire:model="columnMap.name" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                        @foreach($this->previewRows[0] ?? [] as $idx => $cell)
                            <option value="{{ $idx }}">Coluna {{ $idx + 1 }} ({{ Str::limit($cell, 20) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Coluna para Matrícula/Identificador (opcional)</label>
                    <select wire:model="columnMap.identifier" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                        <option value="">— Não usar —</option>
                        @foreach($this->previewRows[0] ?? [] as $idx => $cell)
                            <option value="{{ $idx }}">Coluna {{ $idx + 1 }} ({{ Str::limit($cell, 20) }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Turma de destino</label>
                <select wire:model="schoolClassId" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm">
                    <option value="">Selecione a turma</option>
                    @foreach($this->classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }} @if($class->school) — {{ $class->school->short_name ?? $class->school->name }} @endif</option>
                    @endforeach
                </select>
                @error('schoolClassId')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="overflow-x-auto border border-gray-200 dark:border-gray-600 rounded-lg">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            @foreach($this->previewRows[0] ?? [] as $idx => $cell)
                                <th class="px-3 py-2 text-left text-gray-700 dark:text-gray-300">Col {{ $idx + 1 }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->previewRows as $row)
                            <tr class="border-t border-gray-200 dark:border-gray-600">
                                @foreach($row as $cell)
                                    <td class="px-3 py-2 text-gray-900 dark:text-gray-100">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-wrap gap-2">
                <button type="button" wire:click="import" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                    <x-icon name="check" style="duotone" class="fa-sm" />
                    Importar para a turma
                </button>
                <button type="button" wire:click="back" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700">
                    Trocar arquivo
                </button>
            </div>
        </div>
    @endif
</div>
